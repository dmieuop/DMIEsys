<div>
    <form action="{{ route('student-advisor.update', $selectedStudent ?? '') }}" method="post">
        @csrf @honeypot
        @method('patch')
        <div class="mb-3">
            <label for="batch" class="form-label">Batch</label>
            <select wire:model="selectedBatch" class="form-select" id="batch" name="batch" required>
                <option value="#"> -- Select Batch -- </option>
                @foreach ($batches as $batch)
                <option value="{{ $batch->batch }}">{{ $batch->batch }}</option>
                @endforeach
            </select>
        </div>

        @if (!is_null($selectedBatch))
        <div class="mb-3">
            <label for="student_id" class="form-label">Student ID</label>
            <select wire:model="selectedStudent" class="form-select" id="student_id" name="student_id" required>
                <option value="#"> -- Select Student ID -- </option>
                @foreach ($students as $student)
                <option value="{{ $student->student_id }}">{{ $student->student_id }}</option>
                @endforeach
            </select>
        </div>

        @if (!is_null($selectedStudentHasAdvisor))
        <div class="mb-3">
            <div class="p-4 mb-4 text-sm text-yellow-700 bg-yellow-100 rounded-lg dark:bg-yellow-200 dark:text-yellow-800"
                role="alert">
                <span class="font-medium">Warning!</span> This student adready has a advisor.
            </div>
        </div>
        @endif
        @endif

        @if (!is_null($selectedStudent))
        <div class="mb-3">
            <label for="advisor" class="form-label">Academic Advisor</label>
            <select wire:model="selectedAdvisor" class="form-select" id="advisor" name="advisor" required>
                <option value="#"> -- Select a advisor -- </option>
                @foreach ($advisors as $advisor)
                <option value="{{ $advisor->id }}">{{ $advisor->title }} {{ $advisor->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex mb-3">
            <div class="flex items-center h-5">
                <input id="send-a-mail" name="send-a-mail" aria-describedby="send-a-mail" type="checkbox"
                    class="cursor-pointer w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            </div>
            <div class="ml-3 text-sm">
                <label for="send-a-mail" class="font-medium text-gray-900 dark:text-gray-300 cursor-pointer">Inform
                    the
                    student</label>
                <div class="text-gray-500 dark:text-gray-300"><span class="text-xs font-normal">System will send a
                        email to the student automatically.</span></div>
            </div>
        </div>

        @endif

        @if (!is_null($selectedAdvisor))
        <div class="flex justify-end mt-2">
            <button type="submit" class="mt-3 btn btn-blue">
                <i class="bi bi-save2"></i>
                Update
            </button>
        </div>
        @endif
    </form>
</div>
