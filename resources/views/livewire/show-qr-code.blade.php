<div class="modal-body relative p-4">
    <div class="mb-3 grid grid-cols-1">
        <div class="place-self-center p-3 border-2 border-black mb-2 bg-white">
            {{ QrCode::size($QRcodeSize)->backgroundColor(255, 255, 255)->generate('https://mie.pdn.ac.lk/dmiesys/inventory/' . $itemCode) }}
        </div>
        <div class="text-xs place-self-center mb-2 dark:text-gray-300">{{ $itemCode }}</div>
        <div class="place-self-center print:hidden">
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
    </div>
</div>
