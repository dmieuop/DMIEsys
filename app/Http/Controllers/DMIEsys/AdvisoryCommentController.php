<?php

namespace App\Http\Controllers\DMIEsys;

use App\Mail\SetAMeetingWithStudent;
use App\Models\AdvisoryComment;
use App\Models\Student;
use App\Models\User;
use App\Traits\Notify;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class AdvisoryCommentController extends Controller
{
    use Notify;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if ($this->can('add advisory comments')) {
            $enter_student_advisory_comment_auth = true;
        } else {
            abort(404);
        }
        $students = Student::where('student_advisor', auth()->user()->id)->where('graduated', 0)->get(['student_id', 'name']);
        return view('dmiesys.academics.student-affairs', compact('enter_student_advisory_comment_auth', 'students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $user = User::find(auth()->user()->id);

        if ($user->hasRole('Head of the Department') || $this->can('student counselor')) {
            $resolve_need_my_attention_auth = true;
        } else {
            abort(404);
        }

        $this_is_HOD = false;

        if ($user->hasRole('Head of the Department')) $this_is_HOD = true;

        if ($this_is_HOD) {
            $comments = AdvisoryComment::where('need_hod_attention', 1)
                ->where('handled_by_hod', 0)->with('hasStudent', 'hasAdvisor')->get();
        } else {
            $comments = AdvisoryComment::where('need_sc_attention', 1)
                ->where('handled_by_sc', 0)->with('hasStudent', 'hasAdvisor')->get();
        }

        return view('dmiesys.academics.student-affairs', compact('resolve_need_my_attention_auth', 'comments'));
    }

    public function resolveNeedAttention(int $comment_id)
    {
        $user = User::find(auth()->user()->id);

        if (!($user->hasRole('Head of the Department') || $this->can('student counselor'))) {
            abort(404);
        }

        $this_is_HOD = false;

        if ($user->hasRole('Head of the Department')) $this_is_HOD = true;

        $comment = AdvisoryComment::where('id', $comment_id)->with('hasAdvisor')->firstOrFail();

        try {
            if ($this_is_HOD) {
                $comment->handled_by_hod = 1;
                $comment->save();
                $this->passed('HOD has looked into advisory comment');
                $message = 'HOD has looked into the advisory comment on ' . $comment->student_id . ' you marked for attention.';
            } else {
                $comment->handled_by_sc = 1;
                $comment->save();
                $this->passed('Student Counselor has looked into advisory comment');
                $message = 'Student Counselor has looked into the advisory comment on ' . $comment->student_id . ' you marked for attention.';
            }

            $this->notifyUser($comment->hasAdvisor, $message);
            return back()->with('toast_success', 'Problem resolved successfully!');
        } catch (\Throwable $th) {
            $this->failed($th);
            return back()->withErrors('There was a problem when saving the data, try later!');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        abort_unless(($this->can('add advisory comments')), 404);

        $validated = $request->validate([
            'student_id' => 'required|exists:students',
            'comment' => 'required|string',
            'need_hod_attention' => 'sometimes|required|in:yes',
            'need_sc_attention' => 'sometimes|required|in:yes'
        ]);

        DB::beginTransaction();
        try {
            $data = new AdvisoryComment();
            $data->student_id = $validated['student_id'];
            $data->comment = $validated['comment'];
            $data->commented_by = auth()->user()->id;
            if (Arr::has($validated, 'need_hod_attention')) $data->need_hod_attention = 1;
            if (Arr::has($validated, 'need_sc_attention')) $data->need_sc_attention = 1;
            $data->save();

            $student = Student::where('student_id', $validated['student_id'])->first();
            $student->last_advisory_report = now()->toDateTimeString();
            $student->save();

            if (Arr::has($validated, 'need_hod_attention')) {
                $message = '<span class="bg-red-200 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900">Urgent</span> ' . auth()->user()->title . ' ' . auth()->user()->name . ' has commented something about the student ' . $validated['student_id'] . ' which require your attention.';
                $this->notifyHOD($message);
            }

            if (Arr::has($validated, 'need_sc_attention')) {
                $all_users = User::active()->get();
                foreach ($all_users as $user) {
                    if ($user->hasPermissionTo('student counselor')) {
                        $message = '<span class="bg-red-200 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900">Urgent</span> ' . auth()->user()->title . ' ' . auth()->user()->name . ' has commented something about the student ' . $validated['student_id'] . ' which require your attention.';
                        $this->notifyUser($user, $message);
                    }
                }
            }

            $this->passed('Advisor saved a comment for a student');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->failed($th);
            return back()->withErrors('Comment did not saved. Please try again!');
        }
        DB::commit();
        return back()->with('toast_success', 'Comment saved successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AdvisoryComment  $advisoryComment
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AdvisoryComment  $advisoryComment
     * @return \Illuminate\Http\Response
     */
    public function edit(AdvisoryComment $advisoryComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        abort_unless(($this->can('add advisory comments')), 404);

        $validated = $request->validate([
            'student' => 'required|exists:students,student_id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'meeting_method' => 'required|string|in:online,in-person',
            'meeting_link' => ['sometimes', Rule::requiredIf($request['meeting_method'] == 'online')],
            'message' => 'nullable|string'
        ]);

        try {
            $advisor = User::where('id', auth()->user()->id)->first();
            $student = Student::where('student_id', $validated['student'])->first();
            $body = [
                'advisor' => $advisor['title'] . ' ' . $advisor['name'],
                'email' => $advisor['email'],
                'phone' => $advisor['phone'],
                'student' => $student->name,
                'date' => $validated['date'],
                'time' => $validated['time'],
                'meeting_method' => $validated['meeting_method'],
                'message' => $validated['message'],
                'meeting_link' => $validated['meeting_link'],
            ];
            Mail::to($student->email)->send(new SetAMeetingWithStudent($body));
            $message = 'A meeting was set with ' . $validated['student'] . ' on ' . $validated['date'] . ' at ' . date('h:i a', strtotime($validated['time']));
            $this->notifyUser($advisor, $message);
            return back()->with('toast_success', 'Email was sent to the student.');
        } catch (\Throwable $th) {
            $this->failed($th);
            return back()->withErrors('Something went wrong!');
        }
        dd($validated);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdvisoryComment  $advisoryComment
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdvisoryComment $advisoryComment)
    {
        //
    }
}
