@extends('layouts.dmiesys.app')

@section('title', '| Postgraduate Programme Administration')
@section('back_page', 'Go back to Dashboard')
@section('back_link') {{ route('dashboard') }} @endsection


@push('styles')
@powerGridStyles
@endpush

@section('content')

<div class="px-4 md:px-8">

    @include('components.premission-indicator', [
    'page' => 'Postgraduate Programme Administration',
    ])

    <div class="row">
        <div class="col-md-12">

            @livewire('postgraduate-registration-table')

        </div>
    </div>


</div>

@endsection

@push('scripts')
@powerGridScripts
@endpush