<div class="mt-3">
    <h1 class="inline-block mb-2 text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
        {{ $subject }}
    </h1>
    <div class="mt-3 text-right" id="open_reply_box">
        <button type="button" class="btn btn-green" onclick="ShowReplyBox()">
            <i class="bi bi-reply-fill"></i> Reply to the conversation
        </button>
    </div>
    <form action="{{ route('messages.update', $thread->id) }}" method="post" id="reply_box" class="mt-3 hidden">
        @csrf @honeypot
        @method('patch')

        <!-- Message Form Input -->
        <div class="mb-3">
            <textarea name="message" id="message" class="w-full hidden"
                placeholder="Reply to the conversation">{!! old('message') !!}</textarea>
        </div>

        @if ($users->count() > 0)
        @include('components.multiselect', [
        'users' => $users,
        'To' => 'Add more people to the conversation',
        ])
        @endif

        <!-- Submit Form Input -->
        <div class="mt-2 text-right">
            <button type="submit" class="btn btn-blue">
                <i class="bi bi-reply-fill"></i> Send a reply
            </button>
        </div>
    </form>

</div>
