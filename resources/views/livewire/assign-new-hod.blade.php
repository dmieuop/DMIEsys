<div class="card rounded-2xl">
    <div class="card-body p-4 pb-4">
        @include('components.livewire-error-message')
        <form wire:submit.prevent="submitForm" method="post">
            @csrf @honeypot
            @method('patch')

            <div class="mb-4 rounded-lg bg-yellow-100 p-4 text-sm text-yellow-700 dark:bg-yellow-200 dark:text-yellow-800"
                role="alert">
                <strong>Note: </strong> You can only pick a new HOD only among Professors, Senior Lecturers, Lecturers
                and Probationary Lecturers.Once you assign a new head, your role will change to
                the "Senior Lecturer" (ask new HOD changed it if needed) and you will redirect to the Dashboard. Also
                other users will be notified automatically.
            </div>

            <div class="col-md-12 mb-4">
                <label for="user" class="form-label">Select a new HoD</label>
                <select id="user" class="form-select" wire:model="user" required>
                    <option value="{{ null }}" selected>-- Select a user --</option>
                    @foreach ($activelecturers as $usr)
                    @if ($usr->hasAnyRole(['Professor', 'Senior Lecturer', 'Lecturer', 'Probationary Lecturer']))
                    <option value="{{ $usr->id }}">{{ $usr->title }} {{ $usr->name }} </option>
                    @endif
                    @endforeach
                </select>
                @error('user')
                <span class="font-meduim text-sm text-red-600 dark:text-red-500" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            @include('components.submit-button', [
            'button' => 'Assign new HoD',
            'cancel' => false,
            'color' => 'btn-purple',
            'icon' => 'bi-check2-square',
            'loop' => 'newHOD',
            ])

        </form>
    </div>
</div>
