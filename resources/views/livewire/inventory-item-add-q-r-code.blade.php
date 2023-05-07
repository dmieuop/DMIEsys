@if ($item_code)
    <div class="mx-auto mb-3 grid grid-cols-1 mt-7 md:ml-9">
        <div class="place-self-center p-3 border-2 border-black mb-2 bg-white">
            {{ QrCode::size(old('QRcodeSize') ?? $QRcodeSize)->backgroundColor(255, 255, 255)->generate(old('item_code_link') ?? $item_code_link) }}
        </div>
        <div class="text-xs place-self-center mb-2 dark:text-gray-300">{{ old('item_code') ?? $item_code }}</div>
        <div class="place-self-center">
            <select wire:model="QRcodeSize" class="form-select">
                <option value="50">50x50 &nbsp;&nbsp;&nbsp;&nbsp;</option>
                <option value="75">75x75 &nbsp;&nbsp;&nbsp;&nbsp;</option>
                <option value="100">100x100 &nbsp;&nbsp;&nbsp;&nbsp;</option>
                <option value="125">125x125 &nbsp;&nbsp;&nbsp;&nbsp;</option>
                <option value="150">150x150 &nbsp;&nbsp;&nbsp;&nbsp;</option>
                <option value="175">175x175 &nbsp;&nbsp;&nbsp;&nbsp;</option>
                <option value="200">200x200 &nbsp;&nbsp;&nbsp;&nbsp;</option>
                <option value="225">225x225 &nbsp;&nbsp;&nbsp;&nbsp;</option>
                <option value="250">250x250 &nbsp;&nbsp;&nbsp;&nbsp;</option>
            </select>
        </div>
        <input type="hidden" name="item_code_link" value="{{ $item_code_link }}">
        <input type="hidden" name="QRcodeSize" value="{{ $QRcodeSize }}">
    </div>
@endif
