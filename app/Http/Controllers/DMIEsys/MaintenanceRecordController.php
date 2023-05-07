<?php

namespace App\Http\Controllers\DMIEsys;

use App\Models\MaintenanceRecord;
use App\Traits\Notify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class MaintenanceRecordController extends Controller
{
    use Notify;

    public function index()
    {
        if ($this->can('update maintenance')) {
            $update_maintenance_records_auth = true;
        } else {
            abort(404);
        }

        $today_list = MaintenanceRecord::todayOpen()
            ->where('user_id', auth()->user()->id)->with('hasMachine', 'hasTask')->simplePaginate(1);

        return view('dmiesys.laboratories.manage-machines', compact('update_maintenance_records_auth', 'today_list'));
    }


    // public function create()
    // {
    //     //
    // }


    // public function store(Request $request)
    // {
    //     //
    // }


    // public function show(MaintenanceRecord $maintenanceRecord)
    // {
    //     //
    // }


    // public function edit(MaintenanceRecord $maintenanceRecord)
    // {
    //     //
    // }


    public function update(Request $request, MaintenanceRecord $maintenanceRecord)
    {
        abort_unless(($this->can('update maintenance')), 404);

        Validator::make($request->all(), [
            'comments' => 'nullable|min:5',
        ])->validate();

        if ($request->comments == null) $comment = "The maintenance has been completed";
        else $comment = $request->comments;

        $maintenanceRecord->comments = $comment;
        $maintenanceRecord->save();

        $notification = auth()->user()->title . ' ' . auth()->user()->name . " has executed all of the maintenance duties that were assigned to him for today.";

        $remain_task = MaintenanceRecord::todayOpen()->where('user_id', auth()->user()->id)->count();

        if (!$remain_task) {
            $this->notifySelf("You completed all of today's maintenance tasks.");
            $this->notifyHOD($notification);
        }

        $this->passed('Completed a maintenance');

        return back()->with('toast_success', 'Maintenance completed successfully!');
    }


    // public function destroy(MaintenanceRecord $maintenanceRecord)
    // {
    //     //
    // }
}
