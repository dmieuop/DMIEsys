<div id="alert-additional-content-5"
    class="mt-2 shadow-md dark:shadow-gray-900/80 p-4 mb-3 bg-gray-100 rounded-lg dark:bg-gray-700" role="alert">
    <div class="mt-2 mb-4 text-sm text-gray-700 dark:text-gray-300 font-medium">
        {!! $message->body !!}
    </div>
    <div class="flex items-center flex-row-reverse">
        <div class="flex flex-col pl-2">
            <div class="text-sm font-semibold dark:text-gray-300">{{ $message->user->name }}</div>
            <div class="text-xs text-green-500 dark:text-green-400 font-semibold">
                @if ($message->user->id == auth()->user()->id)
                    Sent
                @else
                    Received
                @endif {{ $message->created_at->diffForHumans() }}
            </div>
        </div>
        <div>
            @include('components.profile-image', [
                'name' => $message->user->name,
                'path' => $message->user->profile_photo_path,
                'size' => '2rem',
            ])
        </div>
    </div>
</div>
