<div class="mb-3">
    {{-- <form wire:submit.prevent="save"> --}}
        <div
            class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl dark:border-gray-700 dark:bg-gray-800">
            @if (is_null($student->profile_photo))
            <img class="object-cover w-full rounded-t-lg h-96 md:h-auto md:w-32 md:rounded-none md:rounded-l-lg"
                src="{{ asset('storage/student-pictures/male-avatar.png') }}" alt="male avatar">
            @else
            <img class="object-cover w-full rounded-t-lg h-96 md:h-auto md:w-32 md:rounded-none md:rounded-l-lg"
                src="{{ asset('storage/student-pictures/' . $student->profile_photo) }}"
                alt="photo of {{ $student->name }}">
            @endif
            <div class="flex flex-col justify-between p-4 pt-0 leading-normal">
                @if (is_null($student->profile_photo))
                <div class="my-3">
                    <input class="form-upload" aria-describedby="photo_help" id="photo" type="file" wire:model="photo"
                        accept="image/png, image/jpeg">
                    @if (session()->has('success'))
                    <p class="text-xs font-semibold text-green-500 dark:text-green-400 mt-2" id="photo_help">
                        {{ session('success') }}
                    </p>
                    @else
                    @error('photo')
                    <p class="text-xs font-semibold text-red-500 dark:text-red-400 mt-2" id="photo_help">
                        {{ $message }}
                    </p>
                    @else
                    <p class="form-input-help" id="photo_help">
                        Your profile picture will be made public.
                    </p>
                    @enderror
                    @endif
                </div>
                @else
                <button type="button" class="btn btn-red my-3" wire:click="deletePhoto">delete my current photo</button>
                @if (session()->has('success'))
                <p class="text-xs font-semibold text-green-500 dark:text-green-400 mb-2" id="photo_help">
                    {{ session('success') }}
                </p>
                @endif
                @endif

                <p class="font-normal text-gray-700 dark:text-gray-400 text-xs">
                    Please provide a professional portrait of yourself with a minimum resolution of 450x600
                    pixels. The image should be in either JPG or PNG format and its file size should be less
                    than 10 megabytes (MB). <br>
                </p>
            </div>
        </div>
        {{--
    </form> --}}
</div>