<div>
    @if ($count > 9)
        <div class="w-5 h-5 bg-red-500 rounded-full absolute right-0 top-0 flex item-center justify-center">
            <span class="text-white font-semibold text-xs">9+</span>
        </div>
        <div class="animate-ping w-5 h-5 bg-red-500 rounded-full absolute right-0 top-0 flex item-center justify-center">
        </div>
    @elseif ($count > 0)
        <div class="w-5 h-5 bg-red-500 rounded-full absolute right-0 top-0 flex item-center justify-center">
            <span class="text-white font-semibold text-xs">{{ $count }}</span>
        </div>
        <div class="animate-ping w-5 h-5 bg-red-500 rounded-full absolute right-0 top-0 flex item-center justify-center">
        </div>
    @endif
</div>
