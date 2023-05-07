<x-action-section>
    <x-slot name="title">
        {{ __('Deactivate Account') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Deactivate your account.') }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
            {{ __('Once your account is deactivated, Your profile will not be visible to others. But your data and past
            activity will remain in the system for administrative purposes. After deactivation you\'ll lose access to
            the DMIEsys dashboard and all the services. If you wish to re-activate your account, request it from system
            administrator through head of the department.') }}
        </div>

        @if (auth()->user()->active_status)
        <div class="mt-5">
            <x-danger-button wire:click="confirmUserDeletion" wire:loading.attr="disabled">
                {{ __('Deactivate Account') }}
            </x-danger-button>
        </div>
        @else
        <div class="mt-5 font-semibold text-red-500">
            Your account is already deactivated!
        </div>
        @endif

        <!-- deactivate User Confirmation Modal -->
        <x-dialog-modal wire:model="confirmingUserDeletion">
            <x-slot name="title">
                {{ __('Deactivate Account') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to deactivate your account? Once your account is deactivated, uou\'ll lose
                access to the DMIEsys dashboard and all the services. Please enter your password to confirm you would
                like to deactivate your account.') }}

                <div class="mt-4" x-data="{}"
                    x-on:confirming-deactivate-user.window="setTimeout(() => $refs.password.focus(), 250)">
                    <x-input type="password" class="mt-1 block w-3/4" placeholder="{{ __('Password') }}"
                        x-ref="password" wire:model.defer="password" wire:keydown.enter="deleteUser" />

                    <x-input-error for="password" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3" wire:click="deleteUser" wire:loading.attr="disabled">
                    {{ __('Deactivate Account') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    </x-slot>
</x-action-section>