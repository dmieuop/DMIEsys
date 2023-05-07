<div>

    <div class="col-md-12 mb-3">
        <label for="batch" class="form-label fw-500 text-muted">Batch</label>
        <select wire:model="selectedBatch" id="batch" name="batch" class="form-select" class="form-select" required>
            <option value="{{ null }}" selected>-- Select --</option>
            @foreach ($batches as $batch)
                <option>{{ $batch->batch }}</option>
            @endforeach
        </select>
    </div>


    <div class="col-md-12 mb-4">
        <label for="student_id" class="form-label fw-500 text-muted">Student ID</label>
        <select wire:model="selectedStudent" id="student_id" name="student_id" class="form-select"
            class="form-select" required>
            <option value="{{ null }}" selected>-- Select --</option>
            @if ($selectedBatch)
                @foreach ($students as $student)
                    <option>{{ $student->student_id }}</option>
                @endforeach
            @endif
        </select>
    </div>

    @if ($selectedStudent)
        <div class="flex justify-end">
            <a class="btn btn-blue" target="_blank" href="{{ route('student-report.show', $selectedStudent) }}">
                <i class="bi bi-search"></i> View Student Report</a>
        </div>
    @endif



</div>
