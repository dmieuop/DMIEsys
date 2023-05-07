@if ($path == null)
<img src="{{ 'https://ui-avatars.com/api/?name=' .urlencode( $name ?? auth()->user()->name). '&color=1E6CE1&background=ACCAF8' }}"
    class="{{ $class ?? '' }} rounded-full" style="width: {{ $size }}; height: {{ $size }}"
    alt="{{  auth()->user()->name }}">
@else
<img src="{{ asset('storage/profile-pictures/' . $path ?? auth()->user()->profile_photo_path) }}"
    class="{{ $class ?? '' }} rounded-full" style="width: {{ $size }}; height: {{ $size }}"
    alt="{{  auth()->user()->name }}">
@endif
