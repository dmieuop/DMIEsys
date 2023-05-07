<?php

namespace App\Http\Controllers\DMIEsys;

use App\Models\AssignmentMark;
use App\Models\Course;
use App\Models\EndMark;
use App\Models\GeneralCourse;
use App\Models\MidMark;
use App\Models\PracticalMark;
use App\Models\QuizMark;
use App\Models\StudentEnrollment;
use App\Models\TutorialMark;
use App\Http\Controllers\Controller;

class CourseReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if ($this->can('see ilo achievement')) {
            $course_ilo_auth = true;
        } else {
            abort(404);
        }

        // $courses = Course::where('status', '=', 'Complete')->paginate(2);

        return view('dmiesys.academics.student-attainment', compact('course_ilo_auth'));
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $course_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(string $course_id)
    {
        abort_unless(($this->can('see ilo achievement')), 404);

        try {
            //return error is course id not complete
            $course = Course::where('course_id', '=', $course_id)->first();
            if ($course == [] || $course->status != 'Complete') {
                return redirect(route('course-report'))->withErrors(['This course is not complete yet or not exist.']);
            }

            //get student list
            $students = StudentEnrollment::where('course_id', '=', $course_id)->get();

            $basecourse = GeneralCourse::where('course_code', '=', $course->course_code)->first();
            $studentmarks = [];

            //create allmarks array
            $allmarks = [];
            for ($i = 0; $i < 101; $i++) {
                $allmarks[$i] = null;
            }
            $maxmark = 0;
            $minmark = 100;
            $avgmark = 0;
            $totalmarks = 0;
            $lomap = [];
            $lomaplbl = [];
            for ($i = 0; $i < $basecourse->total_los; $i++) {
                $lomap[$i] = 0;
                $lomaplbl[$i] = 'LO ' . ($i + 1);
            }

            //calculate final marks
            foreach ($students as $student) {
                $student['lo1'] = 0;
                $student['lo2'] = 0;
                $student['lo3'] = 0;
                $student['lo4'] = 0;
                $student['lo5'] = 0;
                $student['lo6'] = 0;
                $student['total'] = 0;

                $assignmentmarks = AssignmentMark::where('student_id', '=', $student->student_id)->where('course_id', '=', $course_id)->get();
                foreach ($assignmentmarks as $assignmentmark) {
                    for ($i = 1; $i < 7; $i++) {
                        $student['lo' . $i] = $student['lo' . $i] + $assignmentmark->mark * $assignmentmark['lo_' . $i . '_ref'] / 100;
                    }
                }

                $tutorialmarks = TutorialMark::where('student_id', '=', $student->student_id)->where('course_id', '=', $course_id)->get();
                foreach ($tutorialmarks as $tutorialmark) {
                    for ($i = 1; $i < 7; $i++) {
                        $student['lo' . $i] = $student['lo' . $i] + $tutorialmark->mark * $tutorialmark['lo_' . $i . '_ref'] / 100;
                    }
                }

                $quizmarks = QuizMark::where('student_id', '=', $student->student_id)->where('course_id', '=', $course_id)->get();
                foreach ($quizmarks as $quizmark) {
                    for ($i = 1; $i < 7; $i++) {
                        $student['lo' . $i] = $student['lo' . $i] + $quizmark->mark * $quizmark['lo_' . $i . '_ref'] / 100;
                    }
                }

                $practicalmarks = PracticalMark::where('student_id', '=', $student->student_id)->where('course_id', '=', $course_id)->get();
                foreach ($practicalmarks as $practicalmark) {
                    for ($i = 1; $i < 7; $i++) {
                        $student['lo' . $i] = $student['lo' . $i] + $practicalmark->mark * $practicalmark['lo_' . $i . '_ref'] / 100;
                    }
                }

                $midmarks = MidMark::where('student_id', '=', $student->student_id)->where('course_id', '=', $course_id)->get();
                foreach ($midmarks as $midmark) {
                    for ($i = 1; $i < 7; $i++) {
                        $student['lo' . $i] = $student['lo' . $i] + $midmark->mark * $midmark['lo_' . $i . '_ref'] / 100;
                    }
                }

                $endmarks = EndMark::where('student_id', '=', $student->student_id)->where('course_id', '=', $course_id)->get();
                foreach ($endmarks as $endmark) {
                    for ($i = 1; $i < 7; $i++) {
                        $student['lo' . $i] = $student['lo' . $i] + $endmark->mark * $endmark['lo_' . $i . '_ref'] / 100;
                    }
                }


                $student['total'] = $student['lo1'] + $student['lo2'] + $student['lo3'] + $student['lo4'] + $student['lo5'] + $student['lo6'];

                $student['lo1'] = round($student['lo1'], 0);
                $student['lo2'] = round($student['lo2'], 0);
                $student['lo3'] = round($student['lo3'], 0);
                $student['lo4'] = round($student['lo4'], 0);
                $student['lo5'] = round($student['lo5'], 0);
                $student['lo6'] = round($student['lo6'], 0);
                $student['total'] = round($student['total'], 0);

                if ($student['total'] != 0) {
                    array_push($studentmarks, [
                        'student_id' => $student->student_id,
                        'name' => $student['name'],
                        'lo1' => $student['lo1'],
                        'lo2' => $student['lo2'],
                        'lo3' => $student['lo3'],
                        'lo4' => $student['lo4'],
                        'lo5' => $student['lo5'],
                        'lo6' => $student['lo6'],
                        'total' => $student['total'],
                    ]);
                }

                for ($i = 0; $i < $basecourse->total_los; $i++) {
                    if ($student['lo' . ($i + 1)] * 2 >= $basecourse['lo_' . ($i + 1)]) {
                        $lomap[$i]++;
                    }
                }

                if ($student['total'] > $maxmark) {
                    $maxmark = $student['total'];
                }

                if ($student['total'] < $minmark) {
                    $minmark = $student['total'];
                }
                $totalmarks += $student['total'];

                $allmarks[(int) ($student['total'])]++;
                $avgmark = round($totalmarks / count($studentmarks), 1);
            }

            if ($minmark > 0) {
                $firstindex = $minmark - 1;
            } else {
                $firstindex = $minmark;
            }

            if ($maxmark < 100) {
                $lastindex = $maxmark + 1;
            } else {
                $lastindex = $maxmark;
            }

            for ($i = $firstindex; $i <= $lastindex; $i++) {
                if ($allmarks[$i] == null) {
                    $allmarks[$i] = 0;
                }
            }
        } catch (\Throwable $th) {
            $this->failed($th);
            return back()->withErrors("There was a problem, please check the logs to see more about this!");
        }

        $this->passed($course_id . ' course report was viewed');

        return view('dmiesys.academics.view-course-report', compact('course', 'basecourse', 'studentmarks', 'allmarks', 'maxmark', 'minmark', 'avgmark', 'lomap', 'lomaplbl'));
    }
}
