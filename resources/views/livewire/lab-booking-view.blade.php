<div>
    <div class="mb-3">
        <label for="lab" class="form-label">Lab</label>
        <select id="lab" wire:model="selectedLab" class="form-select" name="lab" required>
            <option value="{{ null }}" selected>-- Select a lab --</option>
            @foreach ($labs as $lb)
            <option value="{{ $lb->id }}">{{ $lb->name }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 border border-blue-200 dark:border-blue-400"
            role="alert">
            <span class="font-medium">Note!</span> You can reserve a lab for for next {{ $max_days }} days,
            with a requirement of making the reservation at least {{ $min_days }} days in advance.
        </div>
    </div>

    <div class="mb-3">
        <label for="date" class="form-label">Date</label>
        <input wire:model="selectedDate" type="date" id="date" name="date" class="form-input" value="{{ old('date') }}"
            required>
    </div>

    @if (count($bookings))
        <div class="mb-4">
            <div class="ml-2 grid md:grid-cols-2 gap-x-4 gap-y-2">
                @for ($i = 0; $i <18; $i++)
                    <div class="flex flex-row items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-blue-600 dark:text-gray-400">{{ $times[$i] }}</p>
                        </div>
                        @if ($bookings[$i] == 0)
                        <div>
                            <span
                                class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Available</span>
                        </div>
                        @elseif ($bookings[$i] == 1)
                        <div>
                            <span
                                class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Booked</span>
                        </div>
                        @else
                        <div>
                            <span
                                class="bg-gray-300 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">Not
                                Available</span>
                        </div>
                        @endif
                    </div>
                @endfor

            </div>
        </div>
    @endif
</div>
