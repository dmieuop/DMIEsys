<?php

namespace App\Http\Controllers\DMIEsys;

use App\Models\Lab;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class LabController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if ($this->can('add laboratory')) {
            $add_lab_auth = true;
        } else {
            abort(404);
        }

        $academicstaffs = User::active()->role(['Head of the Department', 'Professor', 'Senior Lecturer', 'Lecturer', 'Contract Basis Lecturer', 'Probationary Lecturer', 'Visiting Lecture', 'Temporary Lecturer', 'Temporary Instructor', 'Instructor'])->get(['id', 'name']);

        $technicalstaffs = User::active()->role(['Technical Officer', 'Instrument Mechanic', 'Machine Operator'])->get(['id', 'name']);

        return view('dmiesys.laboratories.manage-labs', compact('add_lab_auth', 'academicstaffs', 'technicalstaffs'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        abort_unless(($this->can('add laboratory')), 404);

        Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'description' => 'required|string',
            'academicstaff' => 'nullable|exists:users,id',
            'technicalstaff' => 'required|exists:users,id',
            'temporarystaff' => 'nullable|exists:users,id',
        ])->validate();

        try {
            Lab::create([
                'name' => $request->name,
                'description' => $request->description,
                'academicstaff' => $request->academicstaff,
                'technicalstaff' => $request->technicalstaff,
                'temporarystaff' => $request->temporarystaff,
            ]);
        } catch (\Throwable $th) {
            $this->failed($th);
            return back()->withErrors("There was a problem, please check the logs to see more about this!")->withInput();
        }

        $this->passed($request['name'] . ' facility was created');

        return back()->with('toast_success', $request['name'] . ' facility created successfully!');
    }
}
