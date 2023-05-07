<div class="{{ $thread->isUnread(Auth::id()) ? 'bg-cyan-200 dark:bg-green-300' : 'bg-white dark:bg-yellow-200' }} my-4 shadow-md dark:shadow-gray-900/80 px-4 py-2 rounded-lg md:rounded-none  cursor-pointer hover:bg-green-100 dark:hover:bg-yellow-300"
    onclick="window.location.href='{{ route('messages.show', $thread->id) }}';">

    <div class="truncate">
        <span class="font-bold ">{{ $thread->subject }}</span>
        <span class="text-sm">{!! $thread->latestMessage->body !!}</span>
        <p class="truncate dark:text-gray-500 italic">
            <small>(<strong>{{ $thread->creator()->name }},</strong>
                {{ $thread->participantsString($thread->creator()->id) }})</small>
        </p>
    </div>

</div>
