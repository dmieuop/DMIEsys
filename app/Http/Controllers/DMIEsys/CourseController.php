<?php

namespace App\Http\Controllers\DMIEsys;

use App\Jobs\CreateGoogleDriveFolders;
use App\Models\Course;
use App\Models\GeneralCourse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if ($this->can('see course')) {
            $view_course_auth = true;
        } else {
            abort(404);
        }

        $courses = Course::where('created_at', '>', date('Y-m-d', strtotime('-3 years')))->paginate(10);

        return view('dmiesys.academics.manage-courses', compact('view_course_auth', 'courses'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        //variables
        $general_course_list = [];
        $years = [];
        $semesters = [];
        $batches = [];

        if ($this->can('add course')) {
            $create_course_auth = true;
        } else {
            abort(404);
        }

        $general_courses = GeneralCourse::all(['course_code', 'course_name']);

        for ($i = -2; $i < 6; $i++) {
            array_push($years, date('Y', time()) + $i);
            array_push($batches, 'E' . (date('Y', time()) + ($i - 2005)));
        }

        for ($i = 1; $i < 9; $i++) {
            array_push($semesters, $i);
        }

        $lecturers = User::role(['Head of the Department', 'Professor', 'Senior Lecturer', 'Lecturer', 'Contract Basis Lecturer', 'Probationary Lecturer', 'Visiting Lecture', 'Temporary Lecturer'])->active()->get(['username', 'name']);

        $instructors = User::role(['Temporary Lecturer', 'Temporary Instructor', 'Instructor', 'Research Assistant'])->active()->get(['username', 'name']);

        return view('dmiesys.academics.manage-courses', compact('create_course_auth', 'general_courses', 'years', 'semesters', 'batches', 'lecturers', 'instructors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        abort_unless(($this->can('add course')), 404);

        Validator::make($request->all(), [
            'course_id' => 'required|unique:courses',
            'course_code' => 'required|exists:general_courses,course_code',
            'year' => 'required|size:4',
            'semester' => 'required|digits_between:1,8',
            'batch' => 'required|starts_with:E',
            'drive_folder_id' => 'nullable|alpha_dash',
            'period' => 'required',
            'coordinator' => 'required|exists:users,username',
            'moderator' => 'required|exists:users,username',
            'secondexaminer' => 'required|exists:users,username',
            'instructorincharge' => 'required|exists:users,username',
        ])->validate();

        $coordinator = User::where('username', '=', $request['coordinator'])->first();
        $coordinator = $coordinator->title . ' ' . $coordinator->name;
        $moderator = User::where('username', '=', $request['moderator'])->first();
        $moderator = $moderator->title . ' ' . $moderator->name;
        $secondexaminer = User::where('username', '=', $request['secondexaminer'])->first();
        $secondexaminer = $secondexaminer->title . ' ' . $secondexaminer->name;
        $instructorincharge = User::where('username', '=', $request['instructorincharge'])->first();
        $instructorincharge = $instructorincharge->title . ' ' . $instructorincharge->name;

        try {
            Course::create([
                'course_id' => $request['course_id'],
                'course_code' => $request['course_code'],
                'course_name' => GeneralCourse::where('course_code', '=', $request['course_code'])->first()->course_name,
                'year' => $request['year'],
                'semester' => $request['semester'],
                'batch' => $request['batch'],
                'period' => $request['period'],
                'course_folder_id' => $request['drive_folder_id'],
                'coordinator_username' => $request['coordinator'],
                'coordinator' => $coordinator,
                'moderator_username' => $request['moderator'],
                'moderator' => $moderator,
                'secondexaminer_username' => $request['secondexaminer'],
                'secondexaminer' => $secondexaminer,
                'instructorincharge_username' => $request['instructorincharge'],
                'instructorincharge' => $instructorincharge,
            ]);
        } catch (\Throwable $th) {
            $this->failed($th);
            return back()->withErrors("There was a problem, please check the logs to see more about this!");
        }

        $course = Course::where('course_id', $request['course_id'])->first();
        $user = User::find(auth()->user()->id);
        // CreateGoogleDriveFolders::dispatch($course, $user);

        $this->passed($request['course_id'] . ' course was created');

        return back()->with('toast_success', $request['course_id'] . ' course created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $course_id
     * @return \Illuminate\View\View
     */
    public function show(string $course_id)
    {
        abort_unless(($this->can('see course')), 404);

        $course = Course::where('course_id', '=', $course_id)->first();
        $generalcourse = GeneralCourse::where('course_code', '=', $course->course_code)->first();
        $genre = $generalcourse->genre;
        $credit = $generalcourse->credit;

        return view('dmiesys.academics.view-course', compact('course', 'genre', 'credit'));
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $course_id
     * @return \Illuminate\View\View
     */
    public function edit(string $course_id)
    {
        if ($this->can('edit course')) {
            $edit_course_auth = true;
        } else {
            abort(404);
        }

        $years = [];
        $semesters = [];

        $course = Course::where('course_id', '=', $course_id)->first();

        for ($i = -1; $i < 5; $i++) {
            array_push($years, date('Y', time()) + $i);
        }

        for ($i = 1; $i < 9; $i++) {
            array_push($semesters, $i);
        }

        $users = User::where('newuser', '0')->get();

        $lecturers = User::role(['Head of the Department', 'Professor', 'Senior Lecturer', 'Lecturer', 'Contract Basis Lecturer', 'Probationary Lecturer', 'Visiting Lecture', 'Temporary Lecturer'])->active()->get(['username', 'name']);

        $instructors = User::role(['Temporary Lecturer', 'Temporary Instructor', 'Instructor', 'Research Assistant'])->active()->get(['username', 'name']);

        return view('dmiesys.academics.manage-courses', compact('edit_course_auth', 'course', 'years', 'semesters', 'lecturers', 'instructors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $course_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $course_id)
    {
        abort_unless(($this->can('edit course')), 404);

        Validator::make($request->all(), [
            'course_id' => ['required', 'exists:courses', 'in:' . $course_id],
            'year' => 'required|size:4',
            'semester' => 'required|digits_between:1,8',
            'period' => 'required',
            'coordinator' => 'required|exists:users,username',
            'moderator' => 'required|exists:users,username',
            'secondexaminer' => 'required|exists:users,username',
            'instructorincharge' => 'required|exists:users,username',
        ])->validate();

        $coordinator = User::where('username', '=', $request['coordinator'])->first();
        $coordinator = $coordinator->title . ' ' . $coordinator->name;
        $moderator = User::where('username', '=', $request['moderator'])->first();
        $moderator = $moderator->title . ' ' . $moderator->name;
        $secondexaminer = User::where('username', '=', $request['secondexaminer'])->first();
        $secondexaminer = $secondexaminer->title . ' ' . $secondexaminer->name;
        $instructorincharge = User::where('username', '=', $request['instructorincharge'])->first();
        $instructorincharge = $instructorincharge->title . ' ' . $instructorincharge->name;

        try {
            $course = Course::where('course_id', $course_id)->first();
            $course->year = $request['year'];
            $course->semester = $request['semester'];
            $course->period = $request['period'];
            $course->coordinator_username = $request['coordinator'];
            $course->coordinator = $coordinator;
            $course->moderator_username = $request['moderator'];
            $course->moderator = $moderator;
            $course->secondexaminer_username = $request['secondexaminer'];
            $course->secondexaminer = $secondexaminer;
            $course->instructorincharge_username = $request['instructorincharge'];
            $course->instructorincharge = $instructorincharge;
            $course->save();
        } catch (\Throwable $th) {
            $this->failed($th);
            return back()->withErrors("There was a problem, please check the logs to see more about this!");
        }

        $this->passed($request['course_id'] . ' course was updated');

        return redirect()->route('course.index')->with('toast_success', $request['course_id'] . ' course updated successfully!');
    }
}
