<div>
    @auth()
        @can('see notification')
            @if ($has_notification ?? false)
                <script type="text/javascript">
                    playNotificationSound()
                </script>
                <div id="new-notification-toast"
                    class="fixed z-50 bottom-5 left-5 w-full max-w-md p-4 text-gray-500 rounded-lg bg-white border border-t-4 border-l-4 border-blue-600 dark:border-blue-500 shadow-md dark:shadow-gray-900/80 dark:bg-gray-800 dark:text-gray-400 cursor-pointer"
                    role="alert" data-dismiss-target="#new-notification-toast" data-modal-toggle="notification-modal">
                    <div class="flex">
                        <div class="text-sm font-normal">
                            <span class="mb-1 text-sm font-semibold text-gray-900 dark:text-white">New notification</span>
                            <div class="mb-1 text-sm font-normal">{!! $notification !!}</div>
                            <span class="text-xs font-medium text-blue-600 dark:text-blue-500">{{ $time }}</span>
                        </div>
                    </div>
                </div>
            @endif
        @endcan
    @endauth

</div>
