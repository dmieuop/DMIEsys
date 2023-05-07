@extends('layouts.dmiesys.app')

@section('title', '| Inventory Item')
@section('back_page', 'Go back to Inventory')
@section('back_link') {{ route('inventory.index') }} @endsection


@push('styles')
<link rel="stylesheet" href="{{ asset('src/css/ckeditor.css') }}" type="text/css">
@endpush

@section('content')
<div class="mx-auto">
    <div class="screen">

        <div class="font-semibold text-3xl mt-3 mb-5 dark:text-gray-200">Add a new item to the Inventory</div>

        <form action="{{ route('inventory.store') }}" method="post" enctype="multipart/form-data">
            @csrf @honeypot
            <input type="hidden" name="_type" value="add item to inventory">

            @include('components.error-message')

            <div class="grid grid-cols-1 md:grid-cols-5">
                <div class="col-span-3">
                    <div class="grid grid-cols-2 gap-x-3">
                        <div class="mb-3">
                            <label for="item_code" class="form-label">Item Code
                                <sup class="text-red-500">*</sup></label>
                            <input class="form-input" type="text" name="item_code" id="item_code" maxlength="50"
                                value="{{ old('item_code') }}" placeholder="DMIE-IT-CPU-HP-06-017-001"
                                autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label for="item_name" class="form-label">Item Name<sup class="text-red-500">*</sup></label>
                            <input class="form-input" type="text" name="item_name" id="item_name" maxlength="50"
                                value="{{ old('item_name') }}" placeholder="CPU, High back chair" required>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-x-3">
                        <div class="mb-3">
                            <label class="form-label" for="received_date">Received Date<sup
                                    class="text-red-500">*</sup></label>
                            <input class="form-input" type="date" name="received_date" id="received_date"
                                value="{{ old('received_date') }}" placeholder="Received Date" required>
                        </div>
                        <div class="mb-3">
                            <label for="indent_no" class="form-label">Indent No.</label>
                            <input class="form-input" value="{{ old('indent_no') }}" type="text" name="indent_no"
                                id="indent_no" maxlength="100">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="supplier_name" class="form-label">Supplier Name<sup
                                class="text-red-500">*</sup></label>
                        <input class="form-input" type="text" name="supplier_name" id="supplier_name"
                            value="{{ old('supplier_name') }}" maxlength="100" placeholder="Damro Industries (Pvt) Ltd"
                            required>
                    </div>
                    <div class="grid grid-cols-2 gap-x-3">
                        <div class="mb-3">
                            <label for="model" class="form-label">Model</label>
                            <input class="form-input" type="text" name="model" id="model" maxlength="50"
                                value="{{ old('model') }}" placeholder="HP Elite G254">
                        </div>
                        <div class="mb-3">
                            <label for="serial_number" class="form-label">Serial number</label>
                            <input class="form-input" type="text" name="serial_number" id="serial_number"
                                value="{{ old('serial_number') }}" maxlength="50" placeholder="S/N2541-542G">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="properties" class="form-label">Properties<sup class="text-red-500">*</sup></label>
                        <textarea name="properties" class="w-full hidden"
                            id="properties">{!! old('properties') !!}</textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-x-3">
                        <div class="mb-3">
                            <label for="book_no" class="form-label">Book No.<sup class="text-red-500">*</sup></label>
                            <input value="{{ old('book_no') }}" class="form-input" type="number" name="book_no"
                                id="book_no" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="folio_no" class="form-label">Folio No.<sup class="text-red-500">*</sup></label>
                            <input value="{{ old('folio_no') }}" class="form-input" type="number" name="folio_no"
                                id="folio_no" min="0" required>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-x-3">
                        <div class="mb-3">
                            <label for="value" class="form-label">Value</label>
                            <input value="{{ old('value') }}" class="form-input" type="number" name="value" id="value"
                                min="0">
                        </div>
                        <div class="mb-3">
                            <label for="budget_allocation" class="form-label">Budget Allocation</label>
                            <input class="form-input" type="text" name="budget_allocation" id="budget_allocation"
                                value="{{ old('budget_allocation') }}" maxlength="50">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Location<sup class="text-red-500">*</sup></label>
                        <input class="form-input" type="text" name="location" id="location" maxlength="50"
                            value="{{ old('location') }}" placeholder="DMIE CC Lab.." required>
                    </div>
                    <div class="mb-3">
                        <label for="remark" class="form-label">Remark</label>
                        <textarea name="remark" class="form-textarea" id="remark">{{ old('remark') }}</textarea>
                    </div>
                    <div class="mb-5">
                        <label for="photo" class="form-label">Photo</label>
                        <input value="{{ old('photo') }}" class="form-upload" type="file" name="photo" id="photo"
                            accept="image/*">
                    </div>
                    <div class="flex mb-3 justify-between">
                        <button type="reset" class="btn btn-gray">
                            <i class="bi bi-stars"></i> Clear all
                        </button>
                        <button type="submit" class="btn btn-green">
                            <i class="bi bi-save"></i> Add a Item
                        </button>
                    </div>
                </div>
                <div class="mx-auto col-span-2">
                    @livewire('inventory-item-add-q-r-code')
                </div>
            </div>

        </form>

    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('vendor/ckeditor5/build/ckeditor.js') }}"></script>
<script>
    ClassicEditor.create(document.getElementById("properties"))

        const item_code = document.getElementById("item_code");
        item_code.addEventListener('keyup', (event) => {
            window.livewire.emit('updateQRCode', item_code.value);
        });
</script>
@endpush