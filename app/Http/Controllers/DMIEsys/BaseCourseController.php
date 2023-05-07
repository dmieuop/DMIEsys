<?php

namespace App\Http\Controllers\DMIEsys;

use App\Imports\ExcelImport;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\EndExamQuestion;
use App\Models\GeneralCourse;
use App\Models\MidExamQuestion;
use App\Models\Practical;
use App\Models\Quiz;
use App\Models\Tutorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class BaseCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if ($this->can('see base course')) {
            $view_base_course_auth = true;
        } else {
            abort(404);
        }

        $courses = GeneralCourse::paginate(10);

        return view('dmiesys.academics.manage-courses', compact('view_base_course_auth', 'courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if ($this->can('add base course')) {
            $create_base_course_auth = true;
        } else {
            abort(404);
        }

        return view('dmiesys.academics.manage-courses', compact('create_base_course_auth'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        abort_unless(($this->can('add base course')), 404);

        Validator::make($request->all(), [
            'course_code' => 'required|starts_with:PR|unique:general_courses',
            'course_name' => 'required|string|max:100',
            'genre' => 'required|in:cc,tc',
            'credit' => 'required|in:1,2,3,4,5,6',
            'coba_sheet' => 'required|mimes:xls,xlsx|max:5120',
        ])->validate();

        try {
            $file = $request->file('coba_sheet');
            $coba_plan = (new ExcelImport)->toArray($file);
            $coba_plan = $coba_plan[0];

            $lo_1 = 0;
            $lo_2 = 0;
            $lo_3 = 0;
            $lo_4 = 0;
            $lo_5 = 0;
            $lo_6 = 0;
            for ($i = 0; $i < 35; $i++) {
                if (is_numeric($coba_plan[$i]['lo1'])) {
                    $lo_1 += $coba_plan[$i]['lo1'];
                }

                if (is_numeric($coba_plan[$i]['lo2'])) {
                    $lo_2 += $coba_plan[$i]['lo2'];
                }

                if (is_numeric($coba_plan[$i]['lo3'])) {
                    $lo_3 += $coba_plan[$i]['lo3'];
                }

                if (is_numeric($coba_plan[$i]['lo4'])) {
                    $lo_4 += $coba_plan[$i]['lo4'];
                }

                if (is_numeric($coba_plan[$i]['lo5'])) {
                    $lo_5 += $coba_plan[$i]['lo5'];
                }

                if (is_numeric($coba_plan[$i]['lo6'])) {
                    $lo_6 += $coba_plan[$i]['lo6'];
                }
            }
        } catch (\Throwable $th) {
            $this->failed($th);
            return back()->withErrors("There was a problem in uploaded Excel document. Please check your data again.");
        }

        DB::beginTransaction();

        try {
            GeneralCourse::create([
                'course_code' => $request['course_code'],
                'course_name' => $request['course_name'],
                'credit' => $request['credit'],
                'genre' => $request['genre'],
                'total_los' => $coba_plan[0]['amount'],
                'total_assignments' => $coba_plan[1]['amount'],
                'total_tutorials' => $coba_plan[2]['amount'],
                'total_quizzes' => $coba_plan[3]['amount'],
                'total_practicals' => $coba_plan[4]['amount'],
                'total_midquestions' => $coba_plan[5]['amount'],
                'total_endquestions' => $coba_plan[6]['amount'],
                'lo_1' => $lo_1,
                'lo_2' => $lo_2,
                'lo_3' => $lo_3,
                'lo_4' => $lo_4,
                'lo_5' => $lo_5,
                'lo_6' => $lo_6,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->failed($th);
            return back()->withErrors("Could not create a base course. Please check your data again.");
        }

        try {
            for ($i = 0; $i < $coba_plan[1]['amount']; $i++) {
                Assignment::create([
                    'assignment_code' => 'assignment' . $coba_plan[$i]['index'],
                    'course_code' => $request['course_code'],
                    'assignment_name' => $coba_plan[$i]['name'],
                    'lo_1' => $coba_plan[$i]['lo1'] ?? 0,
                    'lo_2' => $coba_plan[$i]['lo2'] ?? 0,
                    'lo_3' => $coba_plan[$i]['lo3'] ?? 0,
                    'lo_4' => $coba_plan[$i]['lo4'] ?? 0,
                    'lo_5' => $coba_plan[$i]['lo5'] ?? 0,
                    'lo_6' => $coba_plan[$i]['lo6'] ?? 0,
                ]);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->failed($th);
            return back()->withErrors("There was a problem when creating an Assignment component. Please check your data.");
        }

        try {
            for ($i = 7; $i < $coba_plan[2]['amount'] + 7; $i++) {
                Tutorial::create([
                    'tutorial_code' => 'tutorial' . $coba_plan[$i]['index'],
                    'course_code' => $request['course_code'],
                    'tutorial_name' => $coba_plan[$i]['name'],
                    'lo_1' => $coba_plan[$i]['lo1'] ?? 0,
                    'lo_2' => $coba_plan[$i]['lo2'] ?? 0,
                    'lo_3' => $coba_plan[$i]['lo3'] ?? 0,
                    'lo_4' => $coba_plan[$i]['lo4'] ?? 0,
                    'lo_5' => $coba_plan[$i]['lo5'] ?? 0,
                    'lo_6' => $coba_plan[$i]['lo6'] ?? 0,
                ]);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->failed($th);
            return back()->withErrors("There was a problem when creating an Tutorial component. Please check your data.");
        }

        try {
            for ($i = 13; $i < $coba_plan[3]['amount'] + 13; $i++) {
                Quiz::create([
                    'quiz_code' => 'quiz' . $coba_plan[$i]['index'],
                    'course_code' => $request['course_code'],
                    'quiz_name' => $coba_plan[$i]['name'],
                    'lo_1' => $coba_plan[$i]['lo1'] ?? 0,
                    'lo_2' => $coba_plan[$i]['lo2'] ?? 0,
                    'lo_3' => $coba_plan[$i]['lo3'] ?? 0,
                    'lo_4' => $coba_plan[$i]['lo4'] ?? 0,
                    'lo_5' => $coba_plan[$i]['lo5'] ?? 0,
                    'lo_6' => $coba_plan[$i]['lo6'] ?? 0,
                ]);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->failed($th);
            return back()->withErrors("There was a problem when creating an Quiz component. Please check your data.");
        }

        try {
            for ($i = 16; $i < $coba_plan[4]['amount'] + 16; $i++) {
                Practical::create([
                    'practical_code' => 'practical' . $coba_plan[$i]['index'],
                    'course_code' => $request['course_code'],
                    'practical_name' => $coba_plan[$i]['name'],
                    'lo_1' => $coba_plan[$i]['lo1'] ?? 0,
                    'lo_2' => $coba_plan[$i]['lo2'] ?? 0,
                    'lo_3' => $coba_plan[$i]['lo3'] ?? 0,
                    'lo_4' => $coba_plan[$i]['lo4'] ?? 0,
                    'lo_5' => $coba_plan[$i]['lo5'] ?? 0,
                    'lo_6' => $coba_plan[$i]['lo6'] ?? 0,
                ]);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->failed($th);
            return back()->withErrors("There was a problem when creating an Practical component. Please check your data.");
        }

        try {
            for ($i = 24; $i < $coba_plan[5]['amount'] + 24; $i++) {
                MidExamQuestion::create([
                    'mid_question_code' => 'midquestion' . $coba_plan[$i]['index'],
                    'course_code' => $request['course_code'],
                    'lo_1' => $coba_plan[$i]['lo1'] ?? 0,
                    'lo_2' => $coba_plan[$i]['lo2'] ?? 0,
                    'lo_3' => $coba_plan[$i]['lo3'] ?? 0,
                    'lo_4' => $coba_plan[$i]['lo4'] ?? 0,
                    'lo_5' => $coba_plan[$i]['lo5'] ?? 0,
                    'lo_6' => $coba_plan[$i]['lo6'] ?? 0,
                ]);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->failed($th);
            return back()->withErrors("There was a problem when creating an Mid Exam Question component. Please check your data.");
        }

        try {
            for ($i = 28; $i < $coba_plan[6]['amount'] + 28; $i++) {
                EndExamQuestion::create([
                    'end_question_code' => 'endquestion' . $coba_plan[$i]['index'],
                    'course_code' => $request['course_code'],
                    'lo_1' => $coba_plan[$i]['lo1'] ?? 0,
                    'lo_2' => $coba_plan[$i]['lo2'] ?? 0,
                    'lo_3' => $coba_plan[$i]['lo3'] ?? 0,
                    'lo_4' => $coba_plan[$i]['lo4'] ?? 0,
                    'lo_5' => $coba_plan[$i]['lo5'] ?? 0,
                    'lo_6' => $coba_plan[$i]['lo6'] ?? 0,
                ]);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->failed($th);
            return back()->withErrors("There was a problem when creating an End Exam Question component. Please check your data.");
        }

        DB::commit();

        $this->passed($request['course_code'] . ' course was created');

        return back()->with('toast_success', $request['course_code'] . ' course created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $course_code
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(string $course_code)
    {
        abort_unless(($this->can('see base course')), 404);

        $basecourse = GeneralCourse::where('course_code', '=', $course_code)->first();
        if ($basecourse == null) {
            return back()->withErrors("Base Course you are looking for is not found!");
        }
        $assignments = Assignment::where('course_code', '=', $course_code)->get();
        $tutorials = Tutorial::where('course_code', '=', $course_code)->get();
        $quizzes = Quiz::where('course_code', '=', $course_code)->get();
        $practicals = Practical::where('course_code', '=', $course_code)->get();
        $midquestions = MidExamQuestion::where('course_code', '=', $course_code)->get();
        $endquestions = EndExamQuestion::where('course_code', '=', $course_code)->get();

        return view('dmiesys.academics.view-base-course', compact('basecourse', 'assignments', 'tutorials', 'quizzes', 'practicals', 'midquestions', 'endquestions'));
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $course_code
     * @return \Illuminate\View\View
     */
    public function edit($course_code)
    {
        if ($this->can('edit base course')) {
            $edit_base_course_auth = true;
        } else {
            abort(404);
        }

        $course = GeneralCourse::where('course_code', '=', $course_code)->first();

        return view('dmiesys.academics.manage-courses', compact('edit_base_course_auth', 'course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $course_code
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $course_code)
    {
        abort_unless(($this->can('edit base course')), 404);

        Validator::make($request->all(), [
            'course_code' => ['required', 'exists:general_courses', 'in:' . $course_code],
            'course_name' => 'required|string|max:100',
            'genre' => 'required|in:cc,tc',
            'credit' => 'required|in:1,2,3,4,5,6',
        ])->validate();

        DB::beginTransaction();
        try {
            GeneralCourse::where('course_code', '=', $course_code)
                ->update($request->only(['course_name', 'genre', 'credit']));

            Course::where('course_code', '=', $course_code)
                ->update($request->only(['course_name']));
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->failed($th);
            return back()->withErrors("There was a problem updating the base course, please try again!");
        }
        DB::commit();
        $this->passed($request['course_code'] . ' course was updated');
        return redirect()->route('base-course.index')->with('success', $request['course_code'] . ' course updated successfully!');
    }
}
