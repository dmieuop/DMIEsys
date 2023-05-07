<?php

namespace App\Http\Controllers\DMIEsys;

use App\Models\AssignmentMark;
use App\Models\Course;
use App\Models\EndMark;
use App\Models\GeneralCourse;
use App\Models\MidMark;
use App\Models\PracticalMark;
use App\Models\QuizMark;
use App\Models\Student;
use App\Models\TutorialMark;
use App\Http\Controllers\Controller;

class StudentReportController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if ($this->can('see attainment report')) {
            $student_attainment_auth = true;
        } else {
            abort(404);
        }
        return view('dmiesys.academics.student-attainment', compact('student_attainment_auth'));
    }

    /**
     * @param string $student_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(string $student_id)
    {
        abort_unless(($this->can('see attainment report')), 404);

        try {
            $studentdetails = Student::where('student_id', '=', $student_id)->first();
            if (!$studentdetails) {
                return back()->withErrors("Student " . $student_id . " was not found.");
            }
            $courselist = [];
            $assignmentmarks = AssignmentMark::where('student_id', '=', $student_id)->get();
            $tutorialmarks = TutorialMark::where('student_id', '=', $student_id)->get();
            $quizmarks = QuizMark::where('student_id', '=', $student_id)->get();
            $practicalmarks = PracticalMark::where('student_id', '=', $student_id)->get();
            $midmarks = MidMark::where('student_id', '=', $student_id)->get();
            $endmarks = EndMark::where('student_id', '=', $student_id)->get();

            //find course list where student entrolled
            foreach ($assignmentmarks as $assignmentmark) {
                array_push($courselist, $assignmentmark->course_id);
            }
            foreach ($tutorialmarks as $tutorialmark) {
                array_push($courselist, $tutorialmark->course_id);
            }
            foreach ($quizmarks as $quizmark) {
                array_push($courselist, $quizmark->course_id);
            }
            foreach ($practicalmarks as $practicalmark) {
                array_push($courselist, $practicalmark->course_id);
            }
            foreach ($midmarks as $midmark) {
                array_push($courselist, $midmark->course_id);
            }
            foreach ($endmarks as $endmark) {
                array_push($courselist, $endmark->course_id);
            }

            //remove duplicates and sort
            $courselist = array_flip($courselist);
            $courselist = array_flip($courselist);
            $courselist = array_values($courselist);
            sort($courselist);

            $coursedetails = [];

            for ($i = 0; $i < count($courselist); $i++) {
                $course = Course::where('course_id', '=', $courselist[$i])->first();
                $basecourse = GeneralCourse::where('course_code', '=', $course->course_code)->first();
                $lo_1 = 0;
                $lo_2 = 0;
                $lo_3 = 0;
                $lo_4 = 0;
                $lo_5 = 0;
                $lo_6 = 0;

                foreach ($assignmentmarks as $assignmentmark) {
                    if ($assignmentmark->course_id == $courselist[$i]) {
                        $lo_1 = $lo_1 + $assignmentmark->mark * $assignmentmark->lo_1_ref / 100;
                        $lo_2 = $lo_2 + $assignmentmark->mark * $assignmentmark->lo_2_ref / 100;
                        $lo_3 = $lo_3 + $assignmentmark->mark * $assignmentmark->lo_3_ref / 100;
                        $lo_4 = $lo_4 + $assignmentmark->mark * $assignmentmark->lo_4_ref / 100;
                        $lo_5 = $lo_5 + $assignmentmark->mark * $assignmentmark->lo_5_ref / 100;
                        $lo_6 = $lo_6 + $assignmentmark->mark * $assignmentmark->lo_6_ref / 100;
                    }
                }

                foreach ($tutorialmarks as $tutorialmark) {
                    if ($tutorialmark->course_id == $courselist[$i]) {
                        $lo_1 = $lo_1 + $tutorialmark->mark * $tutorialmark->lo_1_ref / 100;
                        $lo_2 = $lo_2 + $tutorialmark->mark * $tutorialmark->lo_2_ref / 100;
                        $lo_3 = $lo_3 + $tutorialmark->mark * $tutorialmark->lo_3_ref / 100;
                        $lo_4 = $lo_4 + $tutorialmark->mark * $tutorialmark->lo_4_ref / 100;
                        $lo_5 = $lo_5 + $tutorialmark->mark * $tutorialmark->lo_5_ref / 100;
                        $lo_6 = $lo_6 + $tutorialmark->mark * $tutorialmark->lo_6_ref / 100;
                    }
                }

                foreach ($quizmarks as $quizmark) {
                    if ($quizmark->course_id == $courselist[$i]) {
                        $lo_1 = $lo_1 + $quizmark->mark * $quizmark->lo_1_ref / 100;
                        $lo_2 = $lo_2 + $quizmark->mark * $quizmark->lo_2_ref / 100;
                        $lo_3 = $lo_3 + $quizmark->mark * $quizmark->lo_3_ref / 100;
                        $lo_4 = $lo_4 + $quizmark->mark * $quizmark->lo_4_ref / 100;
                        $lo_5 = $lo_5 + $quizmark->mark * $quizmark->lo_5_ref / 100;
                        $lo_6 = $lo_6 + $quizmark->mark * $quizmark->lo_6_ref / 100;
                    }
                }

                foreach ($practicalmarks as $practicalmark) {
                    if ($practicalmark->course_id == $courselist[$i]) {
                        $lo_1 = $lo_1 + $practicalmark->mark * $practicalmark->lo_1_ref / 100;
                        $lo_2 = $lo_2 + $practicalmark->mark * $practicalmark->lo_2_ref / 100;
                        $lo_3 = $lo_3 + $practicalmark->mark * $practicalmark->lo_3_ref / 100;
                        $lo_4 = $lo_4 + $practicalmark->mark * $practicalmark->lo_4_ref / 100;
                        $lo_5 = $lo_5 + $practicalmark->mark * $practicalmark->lo_5_ref / 100;
                        $lo_6 = $lo_6 + $practicalmark->mark * $practicalmark->lo_6_ref / 100;
                    }
                }

                foreach ($midmarks as $midmark) {
                    if ($midmark->course_id == $courselist[$i]) {
                        $lo_1 = $lo_1 + $midmark->mark * $midmark->lo_1_ref / 100;
                        $lo_2 = $lo_2 + $midmark->mark * $midmark->lo_2_ref / 100;
                        $lo_3 = $lo_3 + $midmark->mark * $midmark->lo_3_ref / 100;
                        $lo_4 = $lo_4 + $midmark->mark * $midmark->lo_4_ref / 100;
                        $lo_5 = $lo_5 + $midmark->mark * $midmark->lo_5_ref / 100;
                        $lo_6 = $lo_6 + $midmark->mark * $midmark->lo_6_ref / 100;
                    }
                }

                foreach ($endmarks as $endmark) {
                    if ($endmark->course_id == $courselist[$i]) {
                        $lo_1 = $lo_1 + $endmark->mark * $endmark->lo_1_ref / 100;
                        $lo_2 = $lo_2 + $endmark->mark * $endmark->lo_2_ref / 100;
                        $lo_3 = $lo_3 + $endmark->mark * $endmark->lo_3_ref / 100;
                        $lo_4 = $lo_4 + $endmark->mark * $endmark->lo_4_ref / 100;
                        $lo_5 = $lo_5 + $endmark->mark * $endmark->lo_5_ref / 100;
                        $lo_6 = $lo_6 + $endmark->mark * $endmark->lo_6_ref / 100;
                    }
                }
                $locount = 0;
                for ($x = 6; $x > $basecourse->total_los; $x--) {
                    $basecourse['lo_' . $x] = 1;
                }
                if ($lo_1 * 2 >= $basecourse->lo_1) {
                    $locount++;
                }
                if ($lo_2 * 2 >= $basecourse->lo_2) {
                    $locount++;
                }
                if ($lo_3 * 2 >= $basecourse->lo_3) {
                    $locount++;
                }
                if ($lo_4 * 2 >= $basecourse->lo_4) {
                    $locount++;
                }
                if ($lo_5 * 2 >= $basecourse->lo_5) {
                    $locount++;
                }
                if ($lo_6 * 2 >= $basecourse->lo_6) {
                    $locount++;
                }

                $final_mark = $lo_1 + $lo_2 + $lo_3 + $lo_4 + $lo_5 + $lo_6;

                array_push($coursedetails, [
                    'course_code' => $course->course_code,
                    'course_id' => $courselist[$i],
                    'genre' => $basecourse->genre,
                    'passed_los' => $locount,
                    'total_los' => $basecourse->total_los,
                    'final_mark' => round($final_mark, 0),
                    'lo_1_ref' => $basecourse->lo_1,
                    'lo_2_ref' => $basecourse->lo_2,
                    'lo_3_ref' => $basecourse->lo_3,
                    'lo_4_ref' => $basecourse->lo_4,
                    'lo_5_ref' => $basecourse->lo_5,
                    'lo_6_ref' => $basecourse->lo_6,
                    'lo_1' => round($lo_1, 0),
                    'lo_2' => round($lo_2, 0),
                    'lo_3' => round($lo_3, 0),
                    'lo_4' => round($lo_4, 0),
                    'lo_5' => round($lo_5, 0),
                    'lo_6' => round($lo_6, 0),
                    'lo_1_%' => $lo_1 * 100 / $basecourse->lo_1,
                    'lo_2_%' => $lo_2 * 100 / $basecourse->lo_2,
                    'lo_3_%' => $lo_3 * 100 / $basecourse->lo_3,
                    'lo_4_%' => $lo_4 * 100 / $basecourse->lo_4,
                    'lo_5_%' => $lo_5 * 100 / $basecourse->lo_5,
                    'lo_6_%' => $lo_6 * 100 / $basecourse->lo_6,
                ]);
            }

            $summary = [
                'total_cc' => 0,
                'passed_cc' => 0,
                'total_tc' => 0,
                'passed_tc' => 0,
                'total_c' => 0,
                'passed_c' => 0,
                'total_lo_cc' => 0,
                'passed_lo_cc' => 0,
                'total_lo_tc' => 0,
                'passed_lo_tc' => 0,
                'total_lo_c' => 0,
                'passed_lo_c' => 0,
                'angle_cc' => 0,
                'angle_lo_cc' => 0,
                'angle_tc' => 0,
                'angle_lo_tc' => 0,
                'angle_c' => 0,
                'angle_lo_c' => 0,
            ];

            foreach ($coursedetails as $coursedetail) {
                if ($coursedetail['genre'] == 'cc') {
                    $summary['total_cc']++;
                    $summary['total_lo_cc'] += $coursedetail['total_los'];
                    $summary['passed_cc']++;
                    for ($i = 1; $i <= $coursedetail['total_los']; $i++) {
                        if ($coursedetail['lo_' . $i . '_%'] < 50) {
                            $summary['passed_cc']--;
                            break;
                        }
                    }
                    $summary['passed_lo_cc'] += $coursedetail['total_los'];
                    for ($i = 1; $i <= $coursedetail['total_los']; $i++) {
                        if ($coursedetail['lo_' . $i . '_%'] < 50) {
                            $summary['passed_lo_cc']--;
                        }
                    }
                }
                if ($coursedetail['genre'] == 'tc') {
                    $summary['total_tc']++;
                    $summary['total_lo_tc'] += $coursedetail['total_los'];
                    $summary['passed_tc']++;
                    for ($i = 1; $i <= $coursedetail['total_los']; $i++) {
                        if ($coursedetail['lo_' . $i . '_%'] < 50) {
                            $summary['passed_tc']--;
                            break;
                        }
                    }
                    $summary['passed_lo_tc'] += $coursedetail['total_los'];
                    for ($i = 1; $i <= $coursedetail['total_los']; $i++) {
                        if ($coursedetail['lo_' . $i . '_%'] < 50) {
                            $summary['passed_lo_tc']--;
                        }
                    }
                }
            }

            $summary['total_c'] = $summary['total_cc'] + $summary['total_tc'];
            $summary['passed_c'] = $summary['passed_cc'] + $summary['passed_tc'];
            $summary['total_lo_c'] = $summary['total_lo_cc'] + $summary['total_lo_tc'];
            $summary['passed_lo_c'] = $summary['passed_lo_cc'] + $summary['passed_lo_tc'];

            if ($summary['total_cc'] != 0) $summary['angle_cc'] = $summary['passed_cc'] * 180 / $summary['total_cc'];
            else $summary['angle_cc'] = 0;

            if ($summary['total_tc'] != 0) $summary['angle_tc'] = $summary['passed_tc'] * 180 / $summary['total_tc'];
            else $summary['angle_tc'] = 0;

            if ($summary['total_lo_cc'] != 0) $summary['angle_c'] = $summary['passed_c'] * 180 / $summary['total_c'];
            else $summary['angle_c'] = 0;

            if ($summary['total_lo_cc'] != 0) $summary['angle_lo_cc'] = $summary['passed_lo_cc'] * 180 / $summary['total_lo_cc'];
            else $summary['angle_lo_cc'] = 0;

            if ($summary['total_lo_tc'] != 0) $summary['angle_lo_tc'] = $summary['passed_lo_tc'] * 180 / $summary['total_lo_tc'];
            else $summary['angle_lo_tc'] = 0;

            if ($summary['total_lo_c'] != 0) $summary['angle_lo_c'] = $summary['passed_lo_c'] * 180 / $summary['total_lo_c'];
            else $summary['angle_lo_c'] = 0;
        } catch (\Throwable $th) {
            $this->failed($th);
            return back()->withErrors("There was a problem, please check the logs to see more about this!");
        }

        $this->passed($student_id . ' student report was viewed');

        return view('dmiesys.academics.view-student-report', compact('studentdetails', 'coursedetails', 'summary'));
    }
}
