@if (session()->has('errors'))
    @if (count($errors->all()) == 1)
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 relative mb-3 rounded-md" role="alert">
            @forelse ($errors->all() as $error)
                <span class="block sm:inline text-sm">{{ $error }}</span>
            @empty
            @endforelse
        </div>
    @elseif (count($errors->all()) > 1)
        <div class="bg-red-100 border-t border-b border-red-500 text-red-700 px-4 py-3 mb-3" role="alert">
            <p class="font-bold">Whoops!</p>
            <ul class="list-disc ml-5">
                @forelse ($errors->all() as $error)
                    <li class="text-sm">{{ $error }}</li>
                @empty
                @endforelse
            </ul>
        </div>
    @endif

@endif
