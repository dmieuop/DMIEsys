<div class="mb-4 mr-3 cursor-pointer w-28" onclick="window.location.href='{{ route($route) }}';">
    <div
        class="rounded-full md:rounded-2xl dark:bg-indigo-300 dark:hover:bg-indigo-400 bg-cyan-500 hover:bg-cyan-600 mb-2 w-16 h-16 flex justify-center py-2 mx-auto">
        <span class="bi bi-{{ $icon }} text-5xl font-semibold"></span>
    </div>
    <div class="p-0">
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-0 font-medium text-center">
            {{ $slot }}</p>
    </div>
</div>