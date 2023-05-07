@if ($paginator->hasPages())
<nav role="navigation" aria-label="Pagination Navigation" class="flex justify-end mb-5">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
    <span
        class="inline-flex items-center py-2 px-4 text-sm font-medium text-gray-500 bg-gray-100 rounded-lg border border-gray-300 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-400 cursor-default">
        {!! __('pagination.previous') !!}
    </span>
    @else
    <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
        class="inline-flex items-center py-2 px-4 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
        {!! __('pagination.previous') !!}
    </a>
    @endif

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}" rel="next"
        class="inline-flex items-center py-2 px-4 ml-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
        {!! __('pagination.next') !!}
    </a>
    @else
    <span
        class="inline-flex items-center py-2 px-4 ml-3 text-sm font-medium text-gray-500 bg-gray-100 rounded-lg border border-gray-300 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-400 cursor-default">
        {!! __('pagination.next') !!}
    </span>
    @endif
</nav>
@endif
