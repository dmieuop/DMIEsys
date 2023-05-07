@extends('layouts.dmiesys.app')

@section('title', '| Inventory')
@section('back_page', 'Go back to Dashboard')
@section('back_link') {{ route('dashboard') }} @endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('src/css/menu.css') }}">
@powerGridStyles
@endpush

@section('content')

<div class="wide-screen">

    <div class="flex mt-3">
        <div class="font-semibold text-4xl mb-3 dark:text-gray-200">Inventory</div>
        <div class="w-full flex space-x-2 justify-end">
            @can('add inventory')
            <button type="button" class="btn btn-black" data-bs-toggle="modal" data-modal-toggle="uploadInventoryList">
                <i class="bi bi-upload"></i> Add new Items (bulk)</a>
            </button>
            <button type="button" class="btn btn-black" onclick="location.href='{{ route('inventory.create') }}'">
                <i class="bi bi-plus"></i> Add a new Item</a>
            </button>
            @endcan
        </div>
    </div>

    @include('components.error-message')

    <!-- QR Code Modal -->
    <div id="showQRcode" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed right-0 left-0 top-4 z-50 justify-center items-center md:inset-0 h-modal sm:h-full">
        <div class="relative px-4 w-full max-w-md h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex justify-between items-start p-5 rounded-t border-b dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl dark:text-white">
                        Item QR Code
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="showQRcode">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="px-6">
                    @livewire('show-qr-code')
                </div>
                <!-- Modal footer -->
                <div
                    class="flex space-x-2 justify-end px-6 py-3 rounded-b border-t border-gray-200 dark:border-gray-600">
                    <button data-modal-toggle="showQRcode" type="button" class="btn btn-gray">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- File Upload Modal -->
    <div id="uploadInventoryList" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed right-0 left-0 top-4 z-50 justify-center items-center h-modal md:h-full md:inset-0">
        <div class="relative px-4 w-full max-w-2xl h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex justify-between items-start p-5 rounded-t border-b dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl dark:text-white">
                        Upload Inventory List
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="uploadInventoryList">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="{{ route('inventory.store') }}" method="post" enctype="multipart/form-data">
                    @csrf @honeypot
                    <input type="hidden" name="_type" value="add items to inventory">
                    <div class="p-6 space-y-6">
                        <div class="mb-3">
                            <label for="inventory_item_list" class="form-label">Select Inventory Item List</label>
                            <input class="form-upload w-full" type="file" name="inventory_item_list"
                                id="inventory_item_list"
                                accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required>
                        </div>
                        <div
                            class="p-4 mb-4 text-sm text-blue-700 bg-blue-100 rounded-lg dark:bg-blue-200 dark:text-blue-800">
                            <span>Please use the provided format for the Inventory item list. For
                                better results, do not enter more than 50 items per one upload.</span>
                            <a target="_blank" href="{{ asset('storage/downloads/Inventory List.xlsx') }}"
                                class="mt-2 block btn-sm btn-gray">Download
                                Inventory Item template</a>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div
                        class="flex space-x-2 justify-end px-6 py-3 rounded-b border-t border-gray-200 dark:border-gray-600">
                        <button data-modal-toggle="uploadInventoryList" type="button" class="btn btn-gray">
                            Cancel
                        </button>
                        <button ype="submit" class="btn btn-green">
                            <i class="bi bi-upload"></i> Upload File
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @livewire('inventory-table')


</div>

@endsection

@push('scripts')
@powerGridScripts
@endpush