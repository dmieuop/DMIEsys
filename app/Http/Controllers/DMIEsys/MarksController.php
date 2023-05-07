<?php

namespace App\Http\Controllers\DMIEsys;

use App\Imports\MarksImport;
use App\Models\Assignment;
use App\Models\AssignmentMark;
use App\Models\Course;
use App\Models\EndExamQuestion;
use App\Models\EndMark;
use App\Models\GeneralCourse;
use App\Models\MidExamQuestion;
use App\Models\MidMark;
use App\Models\Practical;
use App\Models\PracticalMark;
use App\Models\Quiz;
use App\Models\QuizMark;
use App\Models\Student;
use App\Models\StudentEnrollment;
use App\Models\Tutorial;
use App\Models\TutorialMark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class MarksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if ($this->can('delete mark')) {
            $delete_marks_auth = true;
        } else {
            abort(404);
        }

        $courses = Course::where('created_at', '>', date('Y-m-d', strtotime('-3 years')))->where('status', 'Complete')->paginate(10);

        // dd($courses);

        return view('dmiesys.academics.manage-marks', compact('delete_marks_auth', 'courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if ($this->can('add mark')) {
            $manage_marks_auth = true;
        } else {
            abort(404);
        }
        return view('dmiesys.academics.manage-marks', compact('manage_marks_auth'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        abort_unless(($this->can('add mark')), 404);

        Validator::make($request->all(), [
            'mark_sheet' => 'required|mimes:xlsx|max:5120',
        ])->validate();

        $file = $request->file('mark_sheet');
        $marks = Excel::toArray(new MarksImport(), $file);
        $marks = $marks[0];

        //Validating General Information table
        $info = [];
        for ($row = 1; $row <= 10; $row++) {
            if ($row < 3 && $marks[$row][1] == null) {
                return back()->withErrors(['Empty cell in Information table: Row ' . ($row + 1)]);
            }
            $info[$marks[$row][0]] = $marks[$row][1];
        }

        //Validating course code and course id
        Validator::make($info, [
            'Course Code' => 'exists:general_courses,course_code',
            'Course ID' => 'exists:courses,course_id',
        ])->validate();

        //Validating course status
        $course = Course::where('course_id', '=', $info['Course ID'])->first();
        if ($course->status == 'Complete') {
            return back()->withErrors(['This course was marked Complete and you can not upload another marks sheet without deleting the old marks']);
        };

        //Validating sum of Information Table
        if ($info['Assignments'] + $info['Tutorials'] + $info['Quizzes'] + $info['Practicals'] + $info['Mid Exam'] + $info['End Exam'] != 100) {
            return back()->withErrors(['Sum of the components in Information table not equal to 100']);
        }

        //Validating students and get last row number
        $lastrownumber = 0;
        $students_list = [];
        for ($row = 3; $row <= 500; $row++) {
            if ($marks[$row][3] == null) {
                $lastrownumber = $row;
                break;
            }
            $students_list['student_id'] = $marks[$row][3];
            Validator::make($students_list, [
                'student_id' => 'exists:students',
            ])->validate();
        }

        //get the course informations
        $generelcourseinfo = GeneralCourse::where('course_code', '=', $info['Course Code'])->first();

        DB::beginTransaction();

        try {
            //update student table
            for ($row = 3; $row < $lastrownumber; $row++) {
                $student = Student::find($marks[$row][3]);
                $student->hasMarks = 1;
                $student->save();
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->failed($th);
            return back()->withErrors("System failed to enter the marks. Please check your data again.");
        }

        try {
            //update student enrollement table
            for ($row = 3; $row < $lastrownumber; $row++) {
                StudentEnrollment::create([
                    'student_id' => $marks[$row][3],
                    'name' => $marks[$row][4],
                    'course_id' => $info['Course ID'],
                ]);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->failed($th);
            return back()->withErrors("System failed to enter the marks. Please check your data again.");
        }

        try {
            //add marks to assignment marks table
            if ($generelcourseinfo->total_assignments) {
                for ($i = 1; $i <= $generelcourseinfo->total_assignments; $i++) {
                    $assignmentinfo = Assignment::where('assignment_code', '=', 'assignment' . $i)->where('course_code', '=', $info['Course Code'])->first();
                    for ($row = 3; $row < $lastrownumber; $row++) {
                        AssignmentMark::create([
                            'student_id' => $marks[$row][3],
                            'assignment_code' => 'assignment' . $i,
                            'course_id' => $info['Course ID'],
                            'course_code' => $info['Course Code'],
                            'mark' => $marks[$row][4 + $i] * 100 / $marks[2][4 + $i],
                            'lo_1_ref' => $assignmentinfo->lo_1,
                            'lo_2_ref' => $assignmentinfo->lo_2,
                            'lo_3_ref' => $assignmentinfo->lo_3,
                            'lo_4_ref' => $assignmentinfo->lo_4,
                            'lo_5_ref' => $assignmentinfo->lo_5,
                            'lo_6_ref' => $assignmentinfo->lo_6,
                        ]);
                    }
                }
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->failed($th);
            return back()->withErrors("System failed to enter the marks. Please check your data again.");
        }

        try {
            //add marks to tutorials marks table
            if ($generelcourseinfo->total_tutorials) {
                for ($i = 1; $i <= $generelcourseinfo->total_tutorials; $i++) {
                    $tutorialinfo = Tutorial::where('tutorial_code', '=', 'tutorial' . $i)->where('course_code', '=', $info['Course Code'])->first();
                    for ($row = 3; $row < $lastrownumber; $row++) {
                        TutorialMark::create([
                            'student_id' => $marks[$row][3],
                            'tutorial_code' => 'tutorial' . $i,
                            'course_id' => $info['Course ID'],
                            'course_code' => $info['Course Code'],
                            'mark' => $marks[$row][11 + $i] * 100 / $marks[2][11 + $i],
                            'lo_1_ref' => $tutorialinfo->lo_1,
                            'lo_2_ref' => $tutorialinfo->lo_2,
                            'lo_3_ref' => $tutorialinfo->lo_3,
                            'lo_4_ref' => $tutorialinfo->lo_4,
                            'lo_5_ref' => $tutorialinfo->lo_5,
                            'lo_6_ref' => $tutorialinfo->lo_6,
                        ]);
                    }
                }
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->failed($th);
            return back()->withErrors("System failed to enter the marks. Please check your data again.");
        }

        try {
            //add marks to quizzes marks table
            if ($generelcourseinfo->total_quizzes) {
                for ($i = 1; $i <= $generelcourseinfo->total_quizzes; $i++) {
                    $quizinfo = Quiz::where('quiz_code', '=', 'quiz' . $i)->where('course_code', '=', $info['Course Code'])->first();
                    for ($row = 3; $row < $lastrownumber; $row++) {
                        QuizMark::create([
                            'student_id' => $marks[$row][3],
                            'quiz_code' => 'quiz' . $i,
                            'course_id' => $info['Course ID'],
                            'course_code' => $info['Course Code'],
                            'mark' => $marks[$row][17 + $i] * 100 / $marks[2][17 + $i],
                            'lo_1_ref' => $quizinfo->lo_1,
                            'lo_2_ref' => $quizinfo->lo_2,
                            'lo_3_ref' => $quizinfo->lo_3,
                            'lo_4_ref' => $quizinfo->lo_4,
                            'lo_5_ref' => $quizinfo->lo_5,
                            'lo_6_ref' => $quizinfo->lo_6,
                        ]);
                    }
                }
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->failed($th);
            return back()->withErrors("System failed to enter the marks. Please check your data again.");
        }

        try {
            //add marks to practical marks table
            if ($generelcourseinfo->total_practicals) {
                for ($i = 1; $i <= $generelcourseinfo->total_practicals; $i++) {
                    $practicalinfo = Practical::where('practical_code', '=', 'practical' . $i)->where('course_code', '=', $info['Course Code'])->first();
                    for ($row = 3; $row < $lastrownumber; $row++) {
                        PracticalMark::create([
                            'student_id' => $marks[$row][3],
                            'practical_code' => 'practical' . $i,
                            'course_id' => $info['Course ID'],
                            'course_code' => $info['Course Code'],
                            'mark' => $marks[$row][20 + $i] * 100 / $marks[2][20 + $i],
                            'lo_1_ref' => $practicalinfo->lo_1,
                            'lo_2_ref' => $practicalinfo->lo_2,
                            'lo_3_ref' => $practicalinfo->lo_3,
                            'lo_4_ref' => $practicalinfo->lo_4,
                            'lo_5_ref' => $practicalinfo->lo_5,
                            'lo_6_ref' => $practicalinfo->lo_6,
                        ]);
                    }
                }
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->failed($th);
            return back()->withErrors("System failed to enter the marks. Please check your data again.");
        }

        try {
            //add marks to mid_question marks table
            if ($generelcourseinfo->total_midquestions) {
                for ($i = 1; $i <= $generelcourseinfo->total_midquestions; $i++) {
                    $mid_questioninfo = MidExamQuestion::where('mid_question_code', '=', 'midquestion' . $i)->where('course_code', '=', $info['Course Code'])->first();
                    for ($row = 3; $row < $lastrownumber; $row++) {
                        MidMark::create([
                            'student_id' => $marks[$row][3],
                            'mid_question_code' => 'midquestion' . $i,
                            'course_id' => $info['Course ID'],
                            'course_code' => $info['Course Code'],
                            'mark' => $marks[$row][28 + $i] * 100 / $marks[2][28 + $i],
                            'lo_1_ref' => $mid_questioninfo->lo_1,
                            'lo_2_ref' => $mid_questioninfo->lo_2,
                            'lo_3_ref' => $mid_questioninfo->lo_3,
                            'lo_4_ref' => $mid_questioninfo->lo_4,
                            'lo_5_ref' => $mid_questioninfo->lo_5,
                            'lo_6_ref' => $mid_questioninfo->lo_6,
                        ]);
                    }
                }
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->failed($th);
            return back()->withErrors("System failed to enter the marks. Please check your data again.");
        }

        try {
            //add marks to end_question marks table
            if ($generelcourseinfo->total_endquestions) {
                for ($i = 1; $i <= $generelcourseinfo->total_endquestions; $i++) {
                    $end_questioninfo = EndExamQuestion::where('end_question_code', '=', 'endquestion' . $i)->where('course_code', '=', $info['Course Code'])->first();
                    for ($row = 3; $row < $lastrownumber; $row++) {
                        EndMark::create([
                            'student_id' => $marks[$row][3],
                            'end_question_code' => 'endquestion' . $i,
                            'course_id' => $info['Course ID'],
                            'course_code' => $info['Course Code'],
                            'mark' => $marks[$row][33 + $i] * 100 / $marks[2][33 + $i],
                            'lo_1_ref' => $end_questioninfo->lo_1,
                            'lo_2_ref' => $end_questioninfo->lo_2,
                            'lo_3_ref' => $end_questioninfo->lo_3,
                            'lo_4_ref' => $end_questioninfo->lo_4,
                            'lo_5_ref' => $end_questioninfo->lo_5,
                            'lo_6_ref' => $end_questioninfo->lo_6,
                        ]);
                    }
                }
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->failed($th);
            return back()->withErrors("System failed to enter the marks. Please check your data again.");
        }

        try {
            //mark course as complete
            $course = Course::where('course_id', $info['Course ID'])->first();
            $course->status = 'Complete';
            $course->assignmentweight = $marks[5][1] ?? 0;
            $course->tutorialweight = $marks[6][1] ?? 0;
            $course->quizweight = $marks[7][1] ?? 0;
            $course->practicalweight = $marks[8][1] ?? 0;
            $course->midexamweight = $marks[9][1] ?? 0;
            $course->endexamweight = $marks[10][1] ?? 0;
            $course->save();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->failed($th);
            return back()->withErrors("System failed to enter the marks. Please check your data again.");
        }

        DB::commit();

        $this->passed($info['Course ID'] . ' Marks were added.');

        return back()->with('toast_success', $info['Course ID'] . ' marks updated successfully!');
    }

    /**
     * Delete the specified resource in storage.
     *
     * @param  string $course_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $course_id)
    {
        abort_unless(($this->can('delete mark')), 404);

        DB::beginTransaction();
        try {
            AssignmentMark::where('course_id', $course_id)->delete();
            TutorialMark::where('course_id', $course_id)->delete();
            PracticalMark::where('course_id', $course_id)->delete();
            QuizMark::where('course_id', $course_id)->delete();
            MidMark::where('course_id', $course_id)->delete();
            EndMark::where('course_id', $course_id)->delete();
            StudentEnrollment::where('course_id', $course_id)->delete();
        } catch (\Throwable $th) {
            $this->failed($th);
            DB::rollback();
            return back()->withErrors("There was a problem, please check the logs to see more about this!");
        }

        try {
            $course = Course::where('course_id', '=', $course_id)->first();
            $course->assignmentweight = 0;
            $course->tutorialweight = 0;
            $course->practicalweight = 0;
            $course->quizweight = 0;
            $course->midexamweight = 0;
            $course->endexamweight = 0;
            $course->status = 'Ongoing';
            $course->save();
        } catch (\Throwable $th) {
            $this->failed($th);
            DB::rollback();
            return back()->withErrors("There was a problem, please check the logs to see more about this!");
        }

        $this->passed($course_id . ' Marks deleted');

        DB::commit();
        return back()->with('toast_success', $course_id . ' marks deleted successfully!');
    }
}
