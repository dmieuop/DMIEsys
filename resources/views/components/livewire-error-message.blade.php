@if (session()->has('error'))
    <div class="relative mb-3 rounded-md border border-red-400 bg-red-100 px-4 py-3 text-red-700 dark:bg-red-300 dark:text-red-800">
        {{ session('error') }}
    </div>
@endif
@if (session()->has('success'))
    <div class="relative mb-3 rounded-md border border-green-400 bg-green-100 px-4 py-3 text-green-700 dark:bg-green-300 dark:text-green-800">
        {{ session('success') }}
    </div>
@endif
