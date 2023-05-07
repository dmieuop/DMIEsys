<div>
    @foreach ($past_comments as $past_comment)
        @if ($loop->index == 0)
            <p class="text-md text-cyan-600 dark:text-white font-semibold my-2">Last few comments for
                {{ $student_id }},</p>
        @endif
        <div class="p-4 mb-4 text-sm text-blue-700 bg-blue-100 rounded-lg dark:bg-blue-200 dark:text-blue-800 shadow-md dark:shadow-gray-900/80"
            role="alert">
            {{ $past_comment->comment }}
            <span class="flex text-xs font-semibold text-blue-600 dark:text-blue-600 flex-row-reverse">
                {{ $past_comment->created_at->diffForHumans() }}
            </span>
        </div>
    @endforeach
</div>
