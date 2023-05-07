<div class="card rounded-2xl">
    <div class="card-body p-4 pb-4">

        @include('components.livewire-error-message')

        <form wire:submit.prevent="submitForm" method="post">
            @csrf @honeypot

            <div class="mb-4">
                <label for="email" class="form-label fw-500 text-muted">Email
                </label>
                <input type="email" maxlength="50" class="form-input" wire:model="email" id="email" required>
                @error('email')
                <span class="font-meduim text-sm text-red-600 dark:text-red-500" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="role" class="form-label">Assign a role</label>
                <select id="role" class="form-select" wire:model="role" required>
                    <option value="{{ null }}" selected>-- Select a role --</option>
                    @foreach ($roles as $role)
                    @if (auth()->user()->can('add new hod') || $role->name != 'Head of the Department')
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endif
                    @endforeach
                </select>
                @error('role')
                <span class="font-meduim text-sm text-red-600 dark:text-red-500" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            @include('components.submit-button', [
            'button' => 'Add new user',
            'cancel' => false,
            'color' => 'btn-purple',
            'icon' => 'bi-person-plus',
            'loop' => 'addNewUser',
            ])

        </form>
    </div>
</div>
