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
        <label for="batch" class="form-label fw-500 text-muted">Course</label>
        <select wire:model="selectedCourse" id="batch" name="batch" class="form-select" class="form-select"
            required>
            <option value="{{ null }}" selected>-- Select --</option>
            @if ($selectedBatch)
                @foreach ($courses as $course)
                    <option value="{{ $course->course_id }}">{{ $course->course_id }} ({{ $course->course_name }})
                    </option>
                @endforeach
            @endif
        </select>
    </div>

    @if ($selectedCourse)
        <div class="flex justify-end">
            <a class="btn btn-blue" target="_blank" href="{{ route('course-report.show', $selectedCourse) }}">
                <i class="bi bi-search"></i> View Course Report</a>
        </div>
    @endif



</div>
