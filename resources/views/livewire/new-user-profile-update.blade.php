<div class="shadow-md dark:shadow-gray-900/80 bg-white dark:bg-gray-800 p-8 rounded-lg mx-auto max-w-4xl">
    <p class="text-3xl text-blue-700 dark:text-white font-semibold text-center mb-5">Welcome to the DMIEsys</p>

    <form wire:submit.prevent="updateProfile({{ auth()->user()->id }})" method="post">
        @csrf @honeypot
        @method('patch')

        <div class="grid grid-cols-5 gap-x-3">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <select id="title" class="form-select" wire:model="title" required>
                    <option value="{{ null }}" selected> ---- </option>
                    <option>Mr</option>
                    <option>Mrs</option>
                    <option>Miss</option>
                    <option>Ms</option>
                    <option>Dr</option>
                    <option>Prof</option>
                    <option>Eng</option>
                </select>
                @error('title')
                <span class="text-sm font-meduim text-red-600" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="mb-3 col-span-2">
                <label for="fname" class="form-label">First Name
                </label>
                <input wire:model="fname" type="text" maxlength="50" class="form-input" id="fname" required>
                @error('fname')
                <span class="text-sm font-meduim text-red-600" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="mb-3 col-span-2">
                <label for=" lname" class="form-label">Last Name
                </label>
                <input wire:model="lname" type="text" maxlength="50" class="form-input" id="lname" required>
                @error('lname')
                <span class="text-sm font-meduim text-red-600" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="grid grid-cols-2 gap-x-3">
            <div class="mb-3">
                <label for="username" class="form-label">Username
                </label>
                <input wire:model="username" type="text" maxlength="15" class="form-input" id="username" required>
                @error('username')
                <span class="text-sm font-meduim text-red-600" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone (optional)
                </label>
                <input wire:model="phone" type="text" maxlength="20" class="form-input" id="phone">
                @error('phone')
                <span class="text-sm font-meduim text-red-600" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="p-4 mb-4 text-sm text-blue-700 bg-blue-100 rounded-lg dark:bg-blue-200 dark:text-blue-800"
            role="alert">
            Username must be at least 4 characters in length and less than 15 with only letters and numbers. You
            can't change this in future.
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">New Password
            </label>
            <input wire:model="password" type="password" maxlength="50" ria-describedby="passwordHelp"
                class="form-input" id="password" required>
            <div id="passwordHelp" class="mt-2 text-sm text-gray-500 dark:text-gray-400">Password must be 12-30
                characters long, contain letters, numbers and symbol, and must not contain spaces or emoji.</div>
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password
            </label>
            <input wire:model="password_confirmation" type="password" maxlength="50" class="form-input"
                id="password_confirmation" required>
            @error('password')
            <span class="text-sm font-meduim text-red-600" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="flex justify-end mt-5">
            <button class="btn btn-purple" type="submit">Continue <i class="bi bi-chevron-double-right"></i></button>
        </div>
        <div class="flex mt-1">
            <p class="text-red-500 text-sm italic">(Once successful, you'll log out automatically. Use the new username
                and password to sign in afterward)</p>
        </div>
    </form>

</div>
