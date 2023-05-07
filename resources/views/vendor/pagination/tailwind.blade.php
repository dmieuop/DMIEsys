@if ($paginator->hasPages())
<nav aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between mb-5">
    <div class="hidden md:block">
        <p class="text-sm text-gray-700 dark:text-gray-400 leading-5">
            {!! __('Showing') !!}
            @if ($paginator->firstItem())
            <span class="font-medium dark:text-gray-300">{{ $paginator->firstItem() }}</span>
            {!! __('to') !!}
            <span class="font-medium dark:text-gray-300">{{ $paginator->lastItem() }}</span>
            @else
            {{ $paginator->count() }}
            @endif
            {!! __('of') !!}
            <span class="font-medium dark:text-gray-300">{{ $paginator->total() }}</span>
            {!! __('results') !!}
        </p>
    </div>
    <ul class="inline-flex -space-x-px">
        @if ($paginator->onFirstPage())
        <li>
            <a href="#"
                class="py-2 px-3 ml-0 leading-tight text-gray-500 bg-gray-100 rounded-l-lg border border-gray-300 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-400 cursor-default">Previous</a>
        </li>
        @else
        <li>
            <a href="{{ $paginator->previousPageUrl() }}"
                class="py-2 px-3 ml-0 leading-tight text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>
        </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
        <span aria-disabled="true">
            <span
                class="py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 cursor-default">{{
                $element }}</span>
        </span>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
        @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <span aria-current="page">
            <span
                class="py-2 px-3 text-blue-600 bg-blue-50 border border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-white cursor-default">{{
                $page }}</span>
        </span>
        @else
        <li>
            <a href="{{ $url }}"
                class="py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{
                $page }}</a>
        </li>
        @endif
        @endforeach
        @endif
        @endforeach

        @if ($paginator->hasMorePages())
        <li>
            <a href="{{ $paginator->nextPageUrl() }}"
                class="py-2 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Next</a>
        </li>
        @else
        <li>
            <a href="#"
                class="py-2 px-3 leading-tight text-gray-500 bg-gray-100 rounded-r-lg border border-gray-300 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-400 cursor-default">Next</a>
        </li>
        @endif

    </ul>
</nav>
@endif
