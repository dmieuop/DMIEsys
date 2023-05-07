<?php

namespace App\Http\Controllers\DMIEsys;

use App\Models\User;
use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request as NewRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        abort_unless(($this->can('can chat')), 404);

        // All threads that user is participating in
        $threads = Thread::forUser(Auth::id())->latest('updated_at')->paginate(15);

        // All threads that user is participating in, with new messages
        $unread_threads = Thread::forUserWithNewMessages(Auth::id())->latest('updated_at')->get();

        return view('dmiesys.messenger.index', compact('threads', 'unread_threads'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(string $id)
    {
        abort_unless(($this->can('can chat')), 404);
        try {
            $thread = Thread::findOrFail($id);
            abort_unless((Arr::has($thread->participantsUserIds(), auth()->user()->id)), 404);
        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'The thread with ID: ' . $id . ' was not found.');

            return redirect()->route('messages.index');
        }

        $userId = Auth::id();
        $users = User::active()->whereNotIn('id', $thread->participantsUserIds($userId))->get(['id', 'name', 'title', 'profile_photo_path']);

        $thread->markAsRead($userId);

        return view('dmiesys.messenger.show', compact('thread', 'users'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        abort_unless(($this->can('can chat')), 404);

        $users = User::active()->where('id', '!=', Auth::id())->get(['id', 'name', 'title']);

        return view('dmiesys.messenger.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  NewRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(NewRequest $request)
    {
        abort_unless(($this->can('can chat')), 404);

        $request->validate([
            'recipients' => 'required',
        ]);

        DB::beginTransaction();
        try {
            //Thread
            $thread = new Thread();
            $thread->subject = $request->subject;
            $thread->save();

            try {
                // Message
                $message = new Message();
                $message->thread_id = $thread->id;
                $message->user_id = Auth::id();
                $message->body = $request->message;
                $message->save();
            } catch (\Throwable $th) {
                // Message
                $message = new Message();
                $message->thread_id = $thread->id;
                $message->user_id = Auth::id();
                $message->body = $request->message;
                $message->save();
            }

            try {
                // Sender
                $sender = new Participant();
                $sender->thread_id = $thread->id;
                $sender->user_id = Auth::id();
                $sender->last_read = now();
                $sender->save();
            } catch (\Throwable $th) {
                // Sender
                $sender = new Participant();
                $sender->thread_id = $thread->id;
                $sender->user_id = Auth::id();
                $sender->last_read = now();
                $sender->save();
            }

            // Recipients
            if ($request->has('recipients')) {
                $recipients = explode(',', $request->recipients);
                $thread->addParticipant($recipients);
            }

            DB::commit();
        } catch (\Throwable $th) {
            $this->failed($th);
            DB::rollback();
            return back()->withErrors('Message sending failed!');
        }

        return back()->with('toast_success', 'Message sent!');
    }


    /**
     * Update resource in storage.
     *
     * @param  NewRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(NewRequest $request, int $id)
    {
        abort_unless(($this->can('can chat')), 404);

        try {
            $thread = Thread::findOrFail($id);
        } catch (\Throwable $th) {
            Session::flash('error_message', 'The thread with ID: ' . $id . ' was not found.');
            $this->failed($th);
            return redirect()->back();
        }

        DB::beginTransaction();
        try {
            $thread->activateAllParticipants();

            try {
                // Message
                $message = new Message();
                $message->thread_id = $thread->id;
                $message->user_id = Auth::id();
                $message->body = $request->message;
                $message->save();
            } catch (\Throwable $th) {
                $this->failed($th);
            }

            // Add replier as a participant
            $participant = Participant::firstOrCreate([
                'thread_id' => $thread->id,
                'user_id' => Auth::id(),
            ]);
            $participant->last_read = new Carbon;
            $participant->save();

            // Recipients
            if ($request->recipients) {
                $thread->addParticipant(explode(",", $request->recipients));
            }

            DB::commit();
        } catch (\Throwable $th) {
            $this->failed($th);
            DB::rollback();
            return back()->withErrors('Message sending failed!');
        }

        return back()->with('toast_success', 'Message sent!');
    }
}
