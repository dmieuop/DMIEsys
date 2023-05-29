<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        //
    ];


    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('cache:prune-stale-tags')->hourly();
        $schedule->command('AllocateMaintenanceTasks')->onOneServer()->environments(['production'])->dailyAt('00:30');
        $schedule->command('RemindAdvisorsToLogComments')->onOneServer()->environments(['production'])->weeklyOn(2, '8:00');
        $schedule->command('DeactivateOldAccessTable')->onOneServer()->hourly();
    }


    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
