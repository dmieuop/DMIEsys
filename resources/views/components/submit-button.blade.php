{{-- 'cancle' - true (by default) // false
'align' - justify-end (by default) // justify-right
'size' - size (by btn) // btn-sm
'button' - Submit (by default) // any text
'icon' - bi-check2-all (by default) // any bootstrap icon name --}}

<div id="progressbar" class="w-full bg-gray-200 dark:bg-black hidden">
    <div class="bg-blue-400 h-3 transition-transform ease-in-out duration-500 w-100 rounded-md" role="progressbar"
        aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
    </div>
</div>

<div class="flex space-x-2 justify-end  {{ $align ?? 'justify-end' }} mt-5 ">
    @if ($cancel ?? true)
    <button type="button" onclick="window.location.href='{{ $cancel ?? '#' }}'" class="{{ $size ?? 'btn' }} btn-gray">
        <i class="mr-2 -ml-1 w-5 h-5 bi bi-x"></i> Cancel</button>
    @endif
    <!-- Button trigger modal -->
    <button type="button" id="submit" class="{{ $size ?? 'btn' }} {{ $color ?? 'btn-blue' }}"
        data-modal-toggle="confirmBox{{ $loop->index ?? ($loop ?? 'one') }}">
        <i class="mr-2 -ml-1 w-5 h-5 bi {{ $icon ?? 'bi-check2-all' }}"></i>
        {{ $button ?? 'Submit' }}
    </button>
</div>

<!-- Modal -->
<div class="hidden overflow-y-auto overflow-x-hidden fixed right-0 left-0 top-4 z-50 justify-center items-center md:inset-0 h-modal sm:h-full"
    id="confirmBox{{ $loop->index ?? ($loop ?? 'one') }}">
    <div class="relative px-4 w-full max-w-md h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex justify-end p-2">
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                    data-modal-toggle="confirmBox{{ $loop->index ?? ($loop ?? 'one') }}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 pt-0 text-center">
                <svg class="mx-auto mb-4 w-16 h-16 text-yellow-400 dark:text-gray-200" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="my-5 text-md font-normal text-gray-500 dark:text-gray-400">
                    Are you sure you want to do this?
                </p>
                <button data-modal-toggle="confirmBox{{ $loop->index ?? ($loop ?? 'one') }}" type="submit"
                    class="btn-sm btn-red mr-2">
                    Yes, I'm sure
                </button>
                <button data-modal-toggle="confirmBox{{ $loop->index ?? ($loop ?? 'one') }}" type="button"
                    class="btn-sm btn-gray">No, cancel</button>
            </div>
        </div>
    </div>
</div>
