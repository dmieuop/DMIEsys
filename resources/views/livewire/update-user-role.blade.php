<div class="card rounded-2xl">
    <div class="card-body p-4 pb-4">

        @include('components.livewire-error-message')

        <form wire:submit.prevent="submitForm" method="post">
            @csrf @honeypot
            @method('patch')

            <div class="col-md-12 mb-4">
                <label for="user" class="form-label">Select a user</label>
                <select id="user" class="form-select" wire:model="user" required>
                    <option value="{{ null }}" selected>-- Select a user --</option>
                    @foreach ($activeusers as $usr)
                    <option value="{{ $usr->id }}">{{ $usr->title }} {{ $usr->name }}
                        ({{ $usr->getRoleNames()[0] }})
                    </option>
                    @endforeach
                </select>
                @error('user')
                <span class="font-meduim text-sm text-red-600 dark:text-red-500" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="col-md-12 mb-4">
                <label for="role" class="form-label">Assign a role</label>
                <select id="role" class="form-select" wire:model="role" required>
                    <option value="{{ null }}" selected>-- Select a role --</option>
                    @foreach ($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }} </option>
                    @endforeach
                </select>
                @error('role')
                <span class="font-meduim text-sm text-red-600 dark:text-red-500" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            @include('components.submit-button', [
            'button' => 'Update new role',
            'cancel' => false,
            'color' => 'btn-purple',
            'icon' => 'bi-pencil-square',
            'loop' => 'changeUserRole',
            ])

        </form>
    </div>
</div>
