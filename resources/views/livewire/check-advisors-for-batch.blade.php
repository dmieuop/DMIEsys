<div>
    <div class="mb-3">
        <label for="batch" class="form-label">Batch</label>
        <select id="batch" class="form-select" wire:model="selectedBatch" name="batch">
            <option value="{{ null }}"> -- Select Batch -- </option>
            @foreach ($batches as $batch)
                <option value="{{ $batch->batch }}">{{ $batch->batch }}</option>
            @endforeach
        </select>
    </div>

    @if ($selectedBatch)
        <div class="p-4 mb-4 text-sm text-blue-700 bg-blue-100 rounded-lg dark:bg-blue-200 dark:text-blue-800"
            role="alert">
            <span class="font-medium">Note!</span> You can't notify individual students when you are doing bulk
            operations. Also if your list contains more students than the list belows, your operation will not be
            successful.
        </div>
        <div class="mb-5 grid grid-cols-6 gap-y-3 gap-x-4">
            @foreach ($students as $student)
                @if ($student->graduated == 1)
                    <a href="{{ route('student.show', $student->student_id) }}"
                        class="bg-blue-100 hover:bg-blue-200 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800 dark:hover:bg-blue-300 text-center">{{ $student->student_id }}</a>
                @elseif ($student->student_advisor != null)
                    <a href="{{ route('student.show', $student->student_id) }}"
                        class="bg-green-100 hover:bg-green-200 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-800 dark:hover:bg-green-300 text-center">{{ $student->student_id }}</a>
                @else
                    <a href="{{ route('student.show', $student->student_id) }}"
                        class="bg-red-100 hover:bg-red-200 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-800 dark:hover:bg-red-300 text-center">{{ $student->student_id }}</a>
                @endif
            @endforeach
        </div>

        <div class="mb-3 grid grid-cols-3 gap-x-10">
            <span
                class="bg-red-100 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900 text-center">
                no advisor
            </span>
            <span
                class="bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900 text-center">
                has a advisor
            </span>
            <span
                class="bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800 text-center">
                graduated
            </span>
        </div>
    @endif

</div>
