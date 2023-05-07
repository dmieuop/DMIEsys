<?php

namespace App\Http\Controllers\DMIEsys;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if ($this->can('see student')) {
            $view_student_auth = true;
        } else {
            abort(404);
        }
        return view('dmiesys.academics.manage-students', compact('view_student_auth'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if ($this->can('add student')) {
            $enter_student_single_auth = true;
        } else {
            abort(404);
        }
        $batches = [];
        for ($i = -1; $i < 10; $i++) {
            array_push($batches, 'E' . (date('Y', time()) + ($i - 2010)));
        }

        return view('dmiesys.academics.manage-students', compact('enter_student_single_auth', 'batches'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        abort_unless(($this->can('add student')), 404);

        Validator::make($request->all(), [
            'id' => 'required|unique:students,student_id|starts_with:E|size:6',
            'batch' => 'required|starts_with:E',
            'name' => 'required|string',
            'phone' => 'nullable|string|max:15',
            'email' => 'required|email|unique:students',
        ])->validate();

        try {
            Student::create([
                'student_id' => $request['id'],
                'name' => $request['name'],
                'batch' => $request['batch'],
                'phone' => $request['phone'],
                'email' => $request['email'],
            ]);
        } catch (\Throwable $th) {
            $this->failed($th);
            return back()->withErrors("There was a problem, please check the logs to see more about this!");
        }

        $this->passed($request['id'] . ' student record was created');

        return back()->with('toast_success', $request['id'] . ' student added successfully!');
    }

    /**
     * @param string $student_id
     * @return \Illuminate\View\View
     */
    public function show(string $student_id)
    {
        if ($this->can('see student')) {
            $view_student_single_auth = true;
        } else {
            abort(404);
        }

        $canDelete = true;

        $student = Student::findOrFail($student_id);

        return view('dmiesys.academics.manage-students', compact('view_student_single_auth', 'student', 'canDelete'));
    }

    /**
     * @param string $student_id
     * @return \Illuminate\View\View
     */
    public function edit(string $student_id)
    {
        if ($this->can('edit student')) {
            $edit_student_single_auth = true;
        } else {
            abort(404);
        }

        $student = Student::findOrFail($student_id);

        return view('dmiesys.academics.manage-students', compact('edit_student_single_auth', 'student'));
    }

    /**
     * @param string $student_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $student_id)
    {
        abort_unless(($this->can('delete student')), 404);

        try {
            $student = Student::findOrFail($student_id);
            $student->delete();
        } catch (\Throwable $th) {
            $this->failed($th);
            return back()->withErrors("There was a problem, please check the logs to see more about this!");
        }
        $this->passed($student_id . ' student was deleted');

        return redirect()->route('student.index')->with('success', $student_id . ' student deleted successfully!');
    }

    /**
     * @param string $student_id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $student_id)
    {
        abort_unless(($this->can('edit student')), 404);

        Validator::make($request->all(), [
            'student_id' => ['required', 'exists:students', 'in:' . $student_id],
            'name' => 'required|string',
            'phone' => 'nullable|present|string|max:15',
            'email' => 'required|email',
            'profile_link' => 'present|nullable|url',
            'graduated' => 'sometimes|required|in:on',
            'current_working' => 'present',
        ])->validate();

        if ($request['graduated'] == 'on') {
            $graduated = 1;
        } else $graduated = 0;

        try {
            $student = Student::where('student_id', '=', $student_id)->first();
            $student->name = $request['name'];
            $student->phone = $request['phone'];
            $student->email = $request['email'];
            $student->graduated = $graduated;
            $student->profile_link = $request['profile_link'];
            $student->current_working = $request['current_working'];
            $student->save();
        } catch (\Throwable $th) {
            $this->failed($th);
            return back()->withErrors("There was a problem, please check the logs to see more about this!");
        }

        $this->passed($student_id . ' student was updated');

        return redirect()->route('student.show', $student_id)->with('toast_success', $student_id . ' student updated successfully!');
    }
}
