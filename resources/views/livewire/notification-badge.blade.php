<div>
    @if ($hasNoNotification)
        <button type="button" data-modal-toggle="notification-modal"
            class="bg-blue-800 dark:bg-gray-900 p-1 px-2 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
            <span class="sr-only">View notifications</span>
            <!-- Heroicon name: outline/bell -->
            <i class="bi bi-bell text-amber-400 dark:text-red-500 text-lg"></i>
        </button>
    @else
        <button type="button" data-modal-toggle="notification-modal"
            class="bg-blue-800 dark:bg-gray-900 p-1 px-2 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
            <span class="sr-only">View notifications</span>
            <!-- Heroicon name: filled/bell -->
            <i class="bi bi-bell-fill text-amber-400 dark:text-red-500 text-lg"></i>
            <span
                class="absolute top-3 md:right-11 right-14 items-center p-0.5 text-xs font-semibold text-white bg-red-500 rounded-full dark:bg-yellow-400 dark:text-black">
                {{ $notificationCount }}
            </span>
        </button>
    @endif
</div>
