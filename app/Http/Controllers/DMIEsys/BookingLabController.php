<?php

namespace App\Http\Controllers\DMIEsys;

use App\Models\BookingLab;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\FacilityBookingApproved;
use App\Mail\FacilityBookingPlaced;
use App\Mail\FacilityBookingReceived;
use App\Mail\FacilityBookingRejected;
use App\Models\Lab;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class BookingLabController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if ($this->can('approve booking')) {
            $approve_booking_auth = true;
        } else {
            abort(404);
        }

        $bookings = BookingLab::where('rejected', 0)->where('date', '>=', now()->format('Y-m-d'))
            ->where('approved', 0)->where('rejected', 0)
            ->orderBy('date', 'desc')->orderBy('start_time', 'desc')->with('getLab')->get();

        // dd($bookings);

        return view('dmiesys.laboratories.book-facility', compact('approve_booking_auth', 'bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $book_lab_auth = true;

        $starting_times = config('settings.starting_times');
        $ending_times = config('settings.ending_times');

        $min_days = config('settings.booking.min_days');
        $max_days = config('settings.booking.max_days');

        return view('dmiesys.laboratories.book-facility', compact('book_lab_auth', 'starting_times', 'ending_times', 'min_days', 'max_days'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'lab' => 'required|exists:labs,id',
            'date' => ['required', 'date', 'after:' . now()->addDays(config('settings.booking.min_days'))->format('Y-m-d'), 'before:' . now()->addDays(config('settings.booking.max_days'))->format('Y-m-d')],
            'start_time' => 'required|date_format:H:i|before:end_time|after:07:59|before:17:01',
            'end_time' => 'required|date_format:H:i|after:start_time|after:07:59|before:17:01',
            'note' => 'nullable|string',
        ]);

        //validate if the lab is available for booking on the selected date and time

        $bookings = BookingLab::where('date', date('Y-m-d', strtotime($request->date)))
            ->where('lab_id', $request->lab)
            ->where('rejected', 0)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time]);
            })
            ->get();


        if ($bookings->count() > 0) {
            return back()->withErrors('The lab is not available for booking on the selected date and time. Please select another date and time.')->withInput();
        }


        try {
            $lab_booking = new BookingLab();
            $lab_booking->lab_id = $request->lab;
            $lab_booking->date = date('Y-m-d', strtotime($request->date));
            $lab_booking->start_time = date('h:i a', strtotime($request->start_time));
            $lab_booking->end_time = date('h:i a', strtotime($request->start_time));
            $lab_booking->from = 'internal';
            $lab_booking->name = auth()->user()->name;
            $lab_booking->email = auth()->user()->email;
            $lab_booking->phone = auth()->user()->phone;
            $lab_booking->department = 'Department of Manufacturing and Industrial Engineering';
            $lab_booking->notes = $request->note;
            // $lab_booking->save();
        } catch (\Throwable $th) {
            $this->failed($th);
            return back()->withErrors("There was a problem, please check the logs to see more about this!")->withInput();
        }

        $this->passed('Lab booked by internal members ' . auth()->user()->name . ' ' . ' on ' . $request->date . ' from ' . $request->start_time . ' to ' . $request->end_time);

        //send email LabBookingPlaced to the person who placed the booking
        $body = [
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'phone' => auth()->user()->phone,
            'request_type' => 'internal',
            'department' => 'Manufacturing and Industrial Engineering',
            'facility' => Lab::find($request->lab)->name,
            'date' => date('Y-m-d', strtotime($request->date)),
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'notes' => $request->note,
            'url' => route('book-labs.create'),
        ];

        Mail::to(auth()->user()->email)->send(new FacilityBookingPlaced($body));
        Mail::to(config('settings.emails.office'))->send(new FacilityBookingReceived($body));

        return redirect()->route('book-labs.create')->with('toast_success', 'Your booking request has been sent successfully. Please wait for the approval.');
    }

    /**
     * Display the specified resource.
     */
    public function show($booking_id)
    {
        if ($this->can('approve booking')) {
            $approve_booking_single_auth = true;
        } else {
            abort(404);
        }

        $booking = BookingLab::where('id', $booking_id)->where('rejected', 0)->where('approved', 0)->where('date', '>=', now()->format('Y-m-d'))->with('getLab')->firstOrFail();

        $technical_officers = User::active()->role(['Technical Officer', 'Instrument Mechanic', 'Machine Operator'])->get(['id', 'name']);


        return view('dmiesys.laboratories.book-facility', compact('approve_booking_single_auth', 'booking', 'technical_officers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BookingLab $bookingLab)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $booking_id)
    {
        abort_unless(($this->can('approve booking')), 404);

        $booking = BookingLab::where('id', $booking_id)->where('rejected', 0)->where('approved', 0)->where('date', '>=', now()->format('Y-m-d'))->firstOrFail();

        $request->validate([
            'status' => 'required|in:approved,rejected',
            'technical_officer' => 'required_if:status,approved',
        ]);

        if ($request->status == 'approved') {
            $user = User::role(['Technical Officer', 'Instrument Mechanic', 'Machine Operator'])
                ->where('id', $request->technical_officer)->firstOrFail();

            $booking->approved = 1;
            $booking->technical_staff = $request->technical_officer;
            $booking->save();

            //send email LabBookingApproved to the person who placed the booking

            $body = [
                'name' => $booking->name,
                'email' => $booking->email,
                'phone' => $booking->phone,
                'request_type' => 'internal',
                'department' => 'Manufacturing and Industrial Engineering',
                'facility' => Lab::find($booking->lab_id)->name,
                'date' => date('Y-m-d', strtotime($booking->date)),
                'start_time' => $booking->start_time,
                'end_time' => $booking->end_time,
                'notes' => $booking->notes,
                'url' => route('book-labs.create'),
            ];

            Mail::to($booking->email)->send(new FacilityBookingApproved($body));

            return redirect()->route('book-labs.index')->with('toast_success', 'Booking approved successfully!');
        } else {
            $booking->rejected = 1;
            $booking->save();

            //send email LabBookingRejected to the person who placed the booking

            $body = [
                'name' => $booking->name,
                'email' => $booking->email,
                'phone' => $booking->phone,
                'request_type' => 'internal',
                'department' => 'Manufacturing and Industrial Engineering',
                'facility' => Lab::find($booking->lab_id)->name,
                'date' => date('Y-m-d', strtotime($booking->date)),
                'start_time' => $booking->start_time,
                'end_time' => $booking->end_time,
                'notes' => $booking->notes,
                'url' => route('book-labs.create'),
            ];

            Mail::to($booking->email)->send(new FacilityBookingRejected($body));

            return redirect()->route('book-labs.index')->with('toast_success', 'Booking rejected successfully!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookingLab $bookingLab)
    {
        //
    }
}
