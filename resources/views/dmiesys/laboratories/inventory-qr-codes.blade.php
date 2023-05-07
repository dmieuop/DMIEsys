@extends('layouts.dmiesys.app')

@section('title', '| Inventory Item')
@section('back_page', 'Go back to Inventory')
@section('back_link') {{ route('inventory.index') }} @endsection


@push('styles')
<style>
    .main {
        display: flex;
        width: 100%;
        justify-content: center;
    }
</style>
@endpush

@section('content')
<div class="main mx-auto">
    <div class="screen">


        <div class="grid grid-cols-3 gap-4">
            @forelse ($item_code_list as $itemCode)
            <div class="mb-3 grid grid-cols-1">
                <div class="place-self-center p-3 border-2 border-black mb-2 bg-white">
                    {{ QrCode::size(75)->backgroundColor(255, 255,
                    255)->generate('https://mie.pdn.ac.lk/dmiesys/inventory/' . $itemCode) }}
                </div>
                <div class="text-xs place-self-center mb-2 dark:text-gray-300">{{ $itemCode }}</div>
            </div>
            @empty
            @endforelse
        </div>

    </div>
</div>

@endsection

{{-- @push('scripts')
<script src="{{ asset('src/js/manage.courses.js') }}"></script>
@endpush --}}