<?php

namespace App\Http\Controllers\DMIEsys;

use App\Models\Lab;
use App\Models\Machine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class MachineController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if ($this->can('add machine')) {
            $add_machine_auth = true;
        } else {
            abort(404);
        }

        $labs = Lab::all('id', 'name');

        return view('dmiesys.laboratories.manage-machines', compact('add_machine_auth', 'labs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        abort_unless(($this->can('add machine')), 404);

        Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'model' => 'required|string|max:50',
            'mfcountry' => 'nullable|string|max:50',
            'brand' => 'nullable|string|max:50',
            'year_of_made' => 'required|string|max:4',
            'date_of_purchased' => 'required|date|before:today',
            'power_consumption' => 'nullable|digits_between:0,1000000',
            'lab_id' => 'nullable|exists:labs,id',
            'description' => 'nullable|string',
        ])->validate();

        try {
            Machine::create([
                'name' => $request->name,
                'model' => Str::upper($request->model),
                'mfcountry' => $request->mfcountry,
                'brand' => $request->brand,
                'year_of_made' => $request->year_of_made,
                'date_of_purchased' => $request->date_of_purchased,
                'power_consumption' => $request->power_consumption,
                'lab_id' => $request->lab_id,
                'description' => $request->description,
            ]);
        } catch (\Throwable $th) {
            $this->failed($th);
            return back()->withErrors("There was a problem, please check the logs to see more about this!")->withInput();
        }

        $this->passed($request['name'] . ' machine was added.');

        return back()->with('toast_success', $request['name'] . ' machine added successfully!');
    }
}
