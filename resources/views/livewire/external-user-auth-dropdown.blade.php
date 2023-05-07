<div>

    <div class="mb-3">
        <label for="catagory" class="form-label">Who Am I?</label>
        <select wire:model="selectedCategory" class="form-select" id="category" name="category" required>
            <option value="{{ null }}"> -- Select Category -- </option>
            <option value="undergraduate">I am an Undergraduate</option>
            <option value="alumni">I am an Alumni</option>
        </select>
    </div>

    @if ($selectedCategory == 'undergraduate')
    <div class="mb-3">
        <label for="batch" class="form-label">Batch</label>
        <select wire:model="selectedBatch" class="form-select" id="batch" name="batch" required>
            <option value="{{ null }}"> -- Select Batch -- </option>
            @foreach ($batches as $batch)
            <option value="{{ $batch->batch }}">{{ $batch->batch }}</option>
            @endforeach
        </select>
    </div>

    @if (!is_null($selectedBatch))
    <div class="mb-3">
        <label for="student_id" class="form-label">Student ID</label>
        <select wire:model="selectedStudentID" class="form-select" id="student_id" name="student_id" required>
            <option value="{{ null }}"> -- Select Student ID -- </option>
            @foreach ($students as $student)
            <option value="{{ $student->student_id }}">{{ $student->student_id }}</option>
            @endforeach
        </select>
    </div>

    @if (!is_null($selectedStudentID))
    <div class="mb-3">
        <label class="form-label" for="email">Type your email</label>
        <input type="email" class="form-input" name="email" placeholder="{{ $email }}" required>
    </div>
    @endif
    @endif
    @endif

</div>
