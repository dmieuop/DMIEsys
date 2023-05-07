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

        <div class="mb-3 grid grid-cols-1">
            <div class="place-self-center p-3 border-2 border-black mb-2 bg-white">
                {{ QrCode::size(150)->backgroundColor(255, 255,
                255)->generate('https://mie.pdn.ac.lk/dmiesys/inventory/' . $item->item_code) }}
            </div>
            <div class="text-xs place-self-center mb-2 dark:text-gray-300">{{ $item->item_code }}</div>
        </div>


        <div class="flex flex-col">
            <div class="overflow-x-auto shadow-md dark:shadow-gray-900/80 sm:rounded-lg">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden ">
                        <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th scope="col"
                                        class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                        Field
                                    </th>
                                    <th scope="col" style="width: 500px"
                                        class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                        Description
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td
                                        class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        Item Code</td>
                                    <td
                                        class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-wrap dark:text-white">
                                        {{ $item->item_code }}</td>
                                </tr>
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td
                                        class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        Item Name</td>
                                    <td
                                        class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-wrap dark:text-white">
                                        {{ $item->item_name }}</td>
                                </tr>
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td
                                        class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        Received Date</td>
                                    <td
                                        class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-wrap dark:text-white">
                                        {{ $item->received_date }}</td>
                                </tr>
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td
                                        class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        Indent No</td>
                                    <td
                                        class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-wrap dark:text-white">
                                        {{ $item->indent_no }}
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td
                                        class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        Supplier Name</td>
                                    <td
                                        class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-wrap dark:text-white">
                                        {{ $item->supplier_name }}</td>
                                </tr>
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td
                                        class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        Model</td>
                                    <td
                                        class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-wrap dark:text-white">
                                        {{ $item->model }}</td>
                                </tr>
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td
                                        class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        Serial Number</td>
                                    <td
                                        class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-wrap dark:text-white">
                                        {{ $item->serial_number }}</td>
                                </tr>
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td
                                        class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        Properties</td>
                                    <td
                                        class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-wrap dark:text-white">
                                        {{ $item->properties }}</td>
                                </tr>
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td
                                        class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        Book No, Folio No</td>
                                    <td
                                        class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-wrap dark:text-white">
                                        {{ $item->book_no }},{{ $item->folio_no }}</td>
                                </tr>
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td
                                        class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        Value</td>
                                    <td
                                        class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-wrap dark:text-white">
                                        {{ $item->value }}</td>
                                </tr>
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td
                                        class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        Budget Allocation</td>
                                    <td
                                        class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-wrap dark:text-white">
                                        {{ $item->budget_allocation }}</td>
                                </tr>
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td
                                        class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        Location</td>
                                    <td
                                        class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-wrap dark:text-white">
                                        {{ $item->location }}</td>
                                </tr>
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td
                                        class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        Remark</td>
                                    <td
                                        class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-wrap dark:text-white">
                                        {{ $item->remark }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @can('edit inventory')
        <div>
            <x-section-border />
            @include('components.error-message')
            <form action="{{ route('inventory.update', $item->id) }}" method="post" enctype="multipart/form-data">
                @csrf @honeypot
                @method('patch')
                <div class="mb-3">
                    <label for="photo" class="form-label">Select a photo</label>
                    <input class="form-upload w-full" type="file" name="photo" id="photo" wire:model="photo"
                        accept="image/*" required>
                </div>
                <div class="flex justify-between">
                    <button class="btn btn-blue" type="submit">
                        <i class="bi bi-upload"></i> Upload a new photo
                    </button>
                    @if ($item->image_path)
                    <a href="{{ route('inventory.remove.photo', $item->id) }}" class="btn btn-red">
                        <i class="bi bi-trash"></i> Delete current photo
                    </a>
                    @endif
                </div>
            </form>
        </div>
        @endcan
    </div>
</div>
@if ($item->image_path)
<div class="mt-5">
    <img class="mx-auto max-w-md" src="{{ asset('storage/inventory-item-photos/' . $item->image_path) }}"
        alt="{{ $item->item_name }}">
</div>
@endif


@endsection