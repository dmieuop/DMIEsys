@extends('layouts.dmiesys.app')

@section('title', '| Postgraduate Programme Administration')
@section('back_page', 'Go back to Dashboard')
@section('back_link') {{ route('dashboard') }} @endsection


@push('styles')
<link rel="stylesheet" href="{{ asset('src/css/menu.css') }}">
@endpush

@section('content')

<div class="container">

    This page still on development


</div>

@endsection

{{-- @push('scripts')
<script src="{{ asset('src/js/manage.courses.js') }}"></script>
@endpush --}}