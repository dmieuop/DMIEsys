@extends('layouts.dmiesys.app')

@section('title', '| Welcome to DMIEsys')


@push('styles')
<style>
    .main {
        display: flex;
        height: 77vh;
        width: 100%;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush

@section('content')

<div class="screen main" style="margin-top:5vh">

    @livewire('new-user-profile-update')

</div>

@endsection