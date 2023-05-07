<div>
    <div class="mb-3">
        <label for="batch" class="form-label">Batch</label>
        <select wire:model="selectedBatch" class="form-select">
            <option value="#"> -- Select Batch -- </option>
            @foreach ($batches as $batch)
            <option value="{{ $batch->batch }}">{{ $batch->batch }}</option>
            @endforeach
        </select>
    </div>

    @if (!is_null($selectedBatch))
    <div class="mb-3">
        <label for="student_id" class="form-label">Student ID</label>
        <select wire:model="selectedID" class="form-select">
            <option value="#"> -- Select Student ID -- </option>
            @foreach ($students as $student)
            <option value="{{ $student->student_id }}">{{ $student->student_id }}</option>
            @endforeach
        </select>
    </div>
    @endif

    @if (!is_null($selectedID))
    <div class="flex justify-end mt-2">
        <a href="{{ route('student.show', $student_id) }}" class="mt-3 btn btn-blue">
            <i class="bi bi-search"></i>
            Search</a>
    </div>
    @endif
</div>
