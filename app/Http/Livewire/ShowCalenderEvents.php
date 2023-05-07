<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ShowCalenderEvents extends Component
{
    protected $listeners = ['showDayEvents'];

    public function render()
    {
        return view('livewire.show-calender-events');
    }

    public function showDayEvents($date)
    {
        dd($date);
    }
}
