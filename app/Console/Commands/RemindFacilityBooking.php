<?php

namespace App\Console\Commands;

use App\Mail\FacilityBookingRemindingForTO;
use App\Mail\FacilityBookingRemindingForUser;
use App\Models\BookingLab;
use App\Models\Lab;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class RemindFacilityBooking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'RemindFacilityBooking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will check the approved facility booking and send a reminder email to the relevant parties 30min before the booking time.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $bookings = BookingLab::where('approved', 1)->where('date', now()->format('Y-m-d'))->where('start_time', now()->addMinutes(30)->format('H:i:s'))->get();

        // dd($bookings);

        foreach ($bookings as $booking) {
            $user = User::where('id', $booking->technical_staff)->firstOrFail();

            $body = [
                'name' => $booking->name,
                'email' => $booking->email,
                'phone' => $booking->phone,
                'to_name' => $user->name,
                'to_email' => $user->email,
                'to_phone' => $user->phone,
                'department' => 'Manufacturing and Industrial Engineering',
                'facility' => Lab::find($booking->lab_id)->name,
                'date' => date('Y-m-d', strtotime($booking->date)),
                'start_time' => date('h:i a', strtotime($booking->start_time)),
                'end_time' => date('h:i a', strtotime($booking->end_time)),
                'notes' => $booking->notes,
            ];

            Mail::to($user->email)->send(new FacilityBookingRemindingForTO($body));
            Mail::to($booking->email)->send(new FacilityBookingRemindingForUser($body));
        }
    }
}
