<div class="pt-3 pb-5">
    <p class="text-3xl font-medium text-center text-gray-900 dark:text-gray-200 mb-2"> {{ $page ?? '' }} </p>
    <p class="text-md text-center font-light mb-5 text-gray-600 dark:text-gray-400">You're logged as:
        {{ $name ?? auth()->user()->username }} |
        Authorization
        level: {{ $role ?? auth()->user()->getRoleNames()[0] }}
    </p>
</div>