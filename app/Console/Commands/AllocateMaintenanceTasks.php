<?php

namespace App\Console\Commands;

use App\Models\Log;
use App\Models\MaintenanceRecord;
use App\Models\MaintenanceSchedule;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AllocateMaintenanceTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AllocateMaintenanceTasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command runs weekly to find unallocated maintenance tasks and allocate them to responsible staff members.';

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
     * This will allocate the maintain tasks for 1 year for the specific machine
     *
     * @return void
     */
    public function handle()
    {
        $records = MaintenanceSchedule::whereDate('next_run_date', now()->toDateString())->get();

        DB::beginTransaction();

        foreach ($records as $record) {
            try {
                if ($record->WorM == 'W') {
                    for ($due_date = now(), $i = 1; $due_date <= now()->addYear(); $due_date = now()->addWeeks(($record->period * $i)), $i++) {
                        MaintenanceRecord::create([
                            'task_id' => $record->id,
                            'user_id' => $record->user_id,
                            'machine_id' => $record->machine_id,
                            'due_date' => $due_date->toDateString(),
                        ]);
                    }
                    $record->next_run_date = now()->addYear()->addWeeks(($record->period))->toDateString();
                    $record->save();
                }
                if ($record->WorM == 'M') {
                    for ($due_date = now(), $i = 1; $due_date <= now()->addYear(); $due_date = now()->addMonths(($record->period * $i)), $i++) {
                        MaintenanceRecord::create([
                            'task_id' => $record->id,
                            'user_id' => $record->user_id,
                            'machine_id' => $record->machine_id,
                            'due_date' => $due_date->toDateString(),
                        ]);
                    }
                    $record->next_run_date = now()->addYear()->addMonths(($record->period))->toDateString();
                    $record->save();
                }
            } catch (\Throwable $th) {
                DB::rollback();
                Log::create([
                    'user' => 'System',
                    'action' => $th->getMessage(),
                    'state' => 'failed',
                ]);
                break;
            }
        }

        DB::commit();
    }
}
