<div>
    <div class="px-6 pb-1 flex justify-between">
        <button type="button" wire:click="ReadAll"
            class="btn-sm @if ($hasUnreadNotifications) btn-green @else btn-green-disabled @endif">Mark all as
            read ({{ $unread_notifications_count }})</button>
        <button type="button" wire:click="DeleteAll"
            class="btn-sm @if ($hasNotifications) btn-red @else btn-red-disabled @endif">Delete all
            ({{ $all_notifications_count }})</button>
    </div>
    <div class="px-6 space-y-3 overflow-y-auto max-h-144 no-scroll-bar">
        <div class="mb-3">
            @forelse ($all_notifications as $notification)
                @if (!$notification->read_at and $loop->index < 10)
                    <div class="p-4 mb-4 font-medium text-sm text-blue-700 bg-blue-100 rounded-lg dark:bg-blue-200 dark:text-blue-800"
                        role="alert">
                        {!! $notification->data['text'] !!}
                        <div class="flex mt-1">
                            <button wire:click="MarkAsRead('{{ $notification->id }}')" type="button"
                                class="text-white text-xs font-semibold rounded-md mr-2 bg-blue-700 hover:bg-blue-800 dark:bg-blue-600 dark:hover:bg-blue-700 px-2.5 py-0.5">Mark
                                as read</button>
                            <button wire:click="Delete('{{ $notification->id }}')" type="button"
                                class="text-white text-xs font-semibold rounded-md text-black bg-yellow-300 hover:bg-yellow-400 px-2.5 py-0.5">
                                Delete
                            </button>
                        </div>
                    </div>
                @endif
            @empty
                <span class="text-sm text-gray-500 dark:text-gray-400 mb-1 italic">(No notifications)</span>
            @endforelse
            @forelse ($all_notifications as $notification)
                @if ($notification->read_at and $loop->index < 10)
                    <div class="p-4 mb-4 text-sm text-gray-700 bg-gray-100 rounded-lg dark:bg-gray-600 dark:text-gray-300"
                        role="alert">
                        {!! $notification->data['text'] !!}
                        <div class="flex mt-1">
                            <button wire:click="Delete('{{ $notification->id }}')" type="button"
                                class="text-white text-xs font-semibold rounded-md text-black bg-yellow-300 hover:bg-yellow-400  px-2.5 py-0.5">
                                Delete
                            </button>
                        </div>
                    </div>
                @endif
            @empty
            @endforelse
        </div>
    </div>
</div>
