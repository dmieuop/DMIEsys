<?php

namespace App\Http\Controllers\DMIEsys;

use App\Imports\ExcelImport;
use App\Models\Machine;
use App\Models\MaintenanceRecord;
use App\Models\MaintenanceSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class MaintenanceScheduleController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if ($this->can('add maintenance')) {
            $upload_maintenance_schedule_auth = true;
        } else {
            abort(404);
        }

        $machines = Machine::all('id', 'name', 'model', 'brand');

        $tos = User::role(['Technical Officer', 'Instrument Mechanic', 'Machine Operator'])->active()->get(['id', 'title', 'name']);

        return view('dmiesys.laboratories.manage-machines', compact('upload_maintenance_schedule_auth', 'machines', 'tos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        abort_unless(($this->can('add maintenance')), 404);

        Validator::make($request->all(), [
            'machine_id' => 'required|exists:machines,id',
            'user_id' => 'required|exists:users,id',
            'maintenance-schedule' => 'required|mimes:xlsx|max:5120',
            'starting_date' => 'required|date|after:today',
        ])->validate();

        //see if the machine already has a schedule
        $machine = Machine::find($request->machine_id);
        if ($machine->has_maintenances) {
            return back()->withErrors('This machine already has a maintenance schedule going on.');
        }

        //reading file data
        $file = $request->file('maintenance-schedule');
        $schedule = Excel::toArray(new ExcelImport(), $file);
        $schedule = $schedule[0];

        //validate file data
        for ($i = 0; $i < count($schedule); $i++) {
            if ($schedule[$i]['ref_no'] == null) {
                return back()->withErrors('There is a problem with the data in the excel file. Row ' . ($i + 2) . ', `Ref no` field, Please check the data again.');
            }
            if ($schedule[$i]['task'] == null) {
                return back()->withErrors('There is a problem with the data in the excel file. Row ' . ($i + 2) . ', `Task` field, Please check the data again.');
            }
            if ($schedule[$i]['period'] == null) {
                return back()->withErrors('There is a problem with the data in the excel file. Row ' . ($i + 2) . ', `Period` field, Please check the data again.');
            }
            if ($schedule[$i]['week_or_month'] != 'W' and $schedule[$i]['week_or_month'] != 'M') {
                return back()->withErrors('There is a problem with the data in the excel file. Row ' . ($i + 2) . ', `Week or Month` field, Please check the data again.');
            }
        }


        //storing file data
        DB::beginTransaction();
        try {
            for ($i = 0; $i < count($schedule); $i++) {
                MaintenanceSchedule::create([
                    'task' => $schedule[$i]['task'],
                    'period' => $schedule[$i]['period'],
                    'worm' => $schedule[$i]['week_or_month'],
                    'table_ref_no' => $schedule[$i]['ref_no'],
                    'next_run_date' => $request->starting_date,
                    'machine_id' => $request->machine_id,
                    'user_id' => $request->user_id,
                ]);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            $this->failed($th);
            return back()->withErrors("System failed to enter the maintenance schedule.");
        }

        try {
            $machine->has_maintenances = 1;
            $machine->save();
        } catch (\Throwable $th) {
            DB::rollback();
            $this->failed($th);
            return back()->withErrors("System failed to enter the maintenance schedule.");
        }

        DB::commit();
        $this->passed('Maintenance schedule uploaded');

        return back()->with('toast_success', 'Maintenance schedule uploaded successfully!');
    }
}
