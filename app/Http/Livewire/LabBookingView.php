<?php

namespace App\Http\Livewire;

use App\Models\BookingLab;
use App\Models\Lab;
use Livewire\Component;

class LabBookingView extends Component
{
    public $labs = [];
    public $selectedLab = null;
    public $selectedDate = null;
    public $current_bookings = [];
    public $bookings = [];
    public $start_time = [
        '08:00:00', '08:30:00', '09:00:00', '09:30:00', '10:00:00',
        '10:30:00', '11:00:00', '11:30:00', '12:00:00', '12:30:00',
        '13:00:00', '13:30:00', '14:00:00', '14:30:00', '15:00:00',
        '15:30:00', '16:00:00', '16:30:00'
    ];
    public $end_time = [
        '08:29:00', '08:59:00', '09:29:00', '09:59:00', '10:29:00',
        '10:59:00', '11:29:00', '11:59:00', '12:29:00', '12:59:00',
        '13:29:00', '13:59:00', '14:29:00', '14:59:00', '15:29:00',
        '15:59:00', '16:29:00', '16:59:00'
    ];
    public $times = [
        '8:00 AM - 8:29 AM',
        '8:30 AM - 8:59 AM',
        '9:00 AM - 9:29 AM',
        '9:30 AM - 9:59 AM',
        '10:00 AM - 10:29 AM',
        '10:30 AM - 10:59 AM',
        '11:00 AM - 11:29 AM',
        '11:30 AM - 11:59 AM',
        '12:00 PM - 12:29 PM',
        '12:30 PM - 12:59 PM',
        '1:00 PM - 1:29 PM',
        '1:30 PM - 1:59 PM',
        '2:00 PM - 2:29 PM',
        '2:30 PM - 2:59 PM',
        '3:00 PM - 3:29 PM',
        '3:30 PM - 3:59 PM',
        '4:00 PM - 4:29 PM',
        '4:30 PM - 4:59 PM'
    ];

    public function mount()
    {
        $this->labs = Lab::where('book_by_internal_members', 1)->get(['id', 'name']);
    }

    public function render()
    {
        $min_days = config('settings.booking.min_days');
        $max_days = config('settings.booking.max_days');
        return view('livewire.lab-booking-view', compact('min_days', 'max_days'));
    }

    public function showBookingInfo()
    {
        if (!is_null($this->selectedLab) && !is_null($this->selectedDate)) {
            $this->bookings = [0, 0, 0, 0, 0, 0, 0, 0, -2, -2, 0, 0, 0, 0, 0, 0, 0, 0];
            $this->current_bookings = BookingLab::where('date', date('Y-m-d', strtotime($this->selectedDate)))
                ->where('lab_id', $this->selectedLab)
                ->where('rejected', 0)
                ->get(['start_time', 'end_time', 'approved']);
            foreach ($this->current_bookings as $booking) {
                $start_index = array_search($booking->start_time, $this->start_time);
                $end_index = array_search($booking->end_time, $this->end_time);
                for ($i = $start_index; $i <= $end_index; $i++) {
                    if ($booking->approved) $this->bookings[$i] += 1;
                    else $this->bookings[$i] -= 1;
                }
            }
        }
    }

    public function updatedSelectedLab(string $lab_id): void
    {
        $this->selectedLab = $lab_id;
        $this->showBookingInfo();
    }

    public function updatedSelectedDate(string $date): void
    {
        $this->selectedDate = $date;
        $this->showBookingInfo();
    }
}
