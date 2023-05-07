<?php

namespace App\Http\Livewire;

use App\Models\CalenderEvent;
use App\Models\MaintenanceRecord;
use App\Models\User;
use Carbon\CarbonImmutable;
use Livewire\Component;

class DashboardCalender extends Component
{
    public function render()
    {
        $today = date('d', time());
        $first_day = CarbonImmutable::now()->subDays($today - 1);
        $first_day_of_month = strtotime(CarbonImmutable::now()->subDays($today - 1));
        $when_first_day = date('l', $first_day_of_month);

        $days = [];

        switch ($when_first_day) {
            case "Sunday":
                for ($i = 6; $i > 0; $i--) {
                    array_push($days, strtotime($first_day->subDays($i)));
                }
                $count = count($days);
                for ($i = 0; $i < 42 - $count; $i++) {
                    array_push($days, strtotime($first_day->addDays($i)));
                }
                break;
            case "Saturday":
                for ($i = 5; $i > 0; $i--) {
                    array_push($days, strtotime($first_day->subDays($i)));
                }
                $count = count($days);
                for ($i = 0; $i < 42 - $count; $i++) {
                    array_push($days, strtotime($first_day->addDays($i)));
                }
                break;
            case "Friday":
                for ($i = 4; $i > 0; $i--) {
                    array_push($days, strtotime($first_day->subDays($i)));
                }
                $count = count($days);
                for ($i = 0; $i < 42 - $count; $i++) {
                    array_push($days, strtotime($first_day->addDays($i)));
                }
                break;
            case "Thursday":
                for ($i = 3; $i > 0; $i--) {
                    array_push($days, strtotime($first_day->subDays($i)));
                }
                $count = count($days);
                for ($i = 0; $i < 42 - $count; $i++) {
                    array_push($days, strtotime($first_day->addDays($i)));
                }
                break;
            case "Wednesday":
                for ($i = 2; $i > 0; $i--) {
                    array_push($days, strtotime($first_day->subDays($i)));
                }
                $count = count($days);
                for ($i = 0; $i < 42 - $count; $i++) {
                    array_push($days, strtotime($first_day->addDays($i)));
                }
                break;
            case "Tuesday":
                for ($i = 1; $i > 0; $i--) {
                    array_push($days, strtotime($first_day->subDays($i)));
                }
                $count = count($days);
                for ($i = 0; $i < 42 - $count; $i++) {
                    array_push($days, strtotime($first_day->addDays($i)));
                }
                break;
            case "Monday":
                $count = count($days);
                for ($i = 0; $i < 42 - $count; $i++) {
                    array_push($days, strtotime($first_day->addDays($i)));
                }
                break;
        }

        $calender_events = CalenderEvent::where('user_id', auth()->user()->id)
            ->where('date', '>=', now()->subWeeks(5)->toDateString())
            ->where('date', '<', now()->addWeeks(6)->toDateString())->distinct()->get('date');
        $normal_events = [];
        $incomplete_maintain_events = [];
        $complete_maintain_events = [];
        foreach ($calender_events  as $calender_event) {
            array_push($normal_events, $calender_event->date);
        }

        $user = User::find(auth()->user()->id);
        if ($user->hasAnyRole(['Technical Officer', 'Instrument Mechanic', 'Machine Operator'])) {
            $maintenance_records = MaintenanceRecord::where('user_id', auth()->user()->id)
                ->where('due_date', '>=', now()->subWeeks(5)->toDateString())
                ->where('due_date', '<', now()->addWeeks(6)->toDateString())
                ->get(['comments', 'due_date']);
            foreach ($maintenance_records  as $maintenance_record) {
                if ($maintenance_record->comments) array_push($complete_maintain_events, $maintenance_record->due_date);
                else array_push($incomplete_maintain_events, $maintenance_record->due_date);
            }
        }


        return view('livewire.dashboard-calender', [
            'days' => $days,
            'this_month' => date('m', time()),
            'today' => date('Y-m-d', time()),
            'normal_events' => $normal_events,
            'incomplete_maintain_events' => $incomplete_maintain_events,
            'complete_maintain_events' => $complete_maintain_events,
        ]);
    }
}
