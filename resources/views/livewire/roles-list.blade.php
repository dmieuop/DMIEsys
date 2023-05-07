<div class="flex flex-col justify-center h-full">
    <!-- Table -->
    <div
        class="w-full mx-auto bg-white dark:bg-gray-800 shadow-md dark:shadow-gray-900/80 rounded-sm border border-gray-200 dark:border-gray-600">

        <div class="m-10">

            <span class="text-2xl font-semibold dark:text-gray-400">Add a Permission to a Role</span>

            <div class="col-md-12 mb-4 mt-4">
                <label for="role" class="form-label">Select a Role</label>
                <select id="role" class="form-select w-full" wire:model="role" required>
                    <option value="{{ null }}" selected>-- Select a role --</option>
                    @foreach ($all_roles as $all_role)
                        <option value="{{ $all_role->id }}">{{ $all_role->name }}</option>
                    @endforeach
                </select>
            </div>


            @if ($selectRole)
                <div class="grid 2xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 pl-5 mb-5">
                    @foreach ($permissions as $permission)
                        <div>
                            <input class="form-check" type="checkbox" value="{{ $permission->name }}"
                                @if ($selectRole->hasPermissionTo($permission->name)) checked @endif
                                wire:click="SetPermissionForRole('{{ $permission->name }}')"
                                id="checkbox_{{ $loop->index }}">
                            <label class="form-check-label" for="checkbox_{{ $loop->index }}">
                                {{ $permission->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            @endif
            <hr>
            <br>
            <span class="text-2xl font-semibold  dark:text-gray-400">Add a Permission to a User</span>

            <div class="col-md-12 mb-3 mt-4">
                <label for="user" class="form-label">Select a User</label>
                <select id="user" class="form-select w-full" wire:model="user" required>
                    <option value="{{ null }}" selected>-- Select a user --</option>
                    @foreach ($all_users as $all_user)
                        <option value="{{ $all_user->id }}">{{ $all_user->name }}
                            ({{ $all_user->getRoleNames()[0] }})
                        </option>
                    @endforeach
                </select>
            </div>


            @if ($selectUser)
                <div class="p-4 mb-4 text-sm text-yellow-700 bg-yellow-100 rounded-lg dark:bg-yellow-200 dark:text-yellow-800"
                    role="alert">
                    <strong class="font-bold">Note! </strong>
                    <span class="block sm:inline">You can't remove the permissions which are assigned to the
                        user by their Role. They are colored in gray.</span>
                </div>
                <div class="grid 2xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 pl-5 mb-5">
                    @foreach ($permissions as $permission)
                        <div>
                            <input
                                class="form-check @if (!$selectUser->hasDirectPermission($permission->name)) checked:bg-gray-400 dark:checked:bg-gray-400 @else @endif"
                                type="checkbox" value="{{ $permission->name }}"
                                @if ($selectUser->hasPermissionTo($permission->name)) checked @if (!$selectUser->hasDirectPermission($permission->name)) disabled @endif
                                @endif
                            wire:click="SetPermissionForUser('{{ $permission->name }}')"
                            id="checkbox_{{ $loop->index }}">
                            <label class="form-check-label" for="checkbox_{{ $loop->index }}">
                                {{ $permission->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            @endif
            <hr>



            <div class="py-4 border-b border-gray-100 grid grid-cols-1">
                <div class="text-gray-800  dark:text-gray-400 flex-none text-2xl py-auto font-semibold mb-3">
                    <span class="align-middle">User Roles</span>
                </div>
                <div class="text-right flex-auto">
                    <form wire:submit.prevent="Submit" method="post">
                        <input type="text" class="form-input mb-3" wire:model="newRole" required>
                        <button type="submit" class="btn btn-green">
                            <i class="bi bi-plus-circle"></i> Add new role</button>
                    </form>
                </div>
            </div>


            <div class="overflow-x-auto mt-2">

                @include('components.error-message')
                <div class="my-3">
                    {{ $roles->links() }}
                </div>

                <table class="table-auto w-full mt-2">
                    <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50 dark:bg-gray-500">
                        <tr>
                            <th class="p-2 whitespace-nowrap">
                                <div class="font-semibold text-left dark:text-gray-200">Role</div>
                            </th>
                            <th class="p-2 whitespace-nowrap">
                                <div class="font-semibold text-left dark:text-gray-200">Permissions belongs to the role
                                </div>
                            </th>
                            <th class="p-2 whitespace-nowrap">
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-100">
                        @foreach ($roles as $role)
                            <tr>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-md dark:text-gray-300">
                                        {{ $role->name }}
                                    </div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-left flex flex-wrap">
                                        @forelse ($role->getAllPermissions() as $p)
                                            <div
                                                class="bg-purple-100 text-purple-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-purple-200 dark:text-purple-900 cursor-default">
                                                {{ $p->name }}</div>
                                        @empty
                                            <div class="italic text-gray-500 text-sm">(no permissions yet)</div>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-md text-right">
                                        <button type="button" class="btn-sm btn-red"
                                            data-modal-toggle="confirmBox{{ $loop->index ?? ($loop ?? 'one') }}">
                                            <i class="bi bi-trash"></i> Delete</button>
                                    </div>
                                    <!-- Modal -->
                                    <div class="hidden overflow-y-auto overflow-x-hidden fixed right-0 left-0 top-4 z-50 justify-center items-center md:inset-0 h-modal sm:h-full"
                                        id="confirmBox{{ $loop->index ?? ($loop ?? 'one') }}">
                                        <div class="relative px-4 w-full max-w-md h-full md:h-auto">
                                            <!-- Modal content -->
                                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                <!-- Modal header -->
                                                <div class="flex justify-end p-2">
                                                    <button type="button"
                                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                                                        data-modal-toggle="confirmBox{{ $loop->index ?? ($loop ?? 'one') }}">
                                                        <svg class="w-5 h-5" fill="currentColor"
                                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd"
                                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="p-6 pt-0 text-center">
                                                    <svg class="mx-auto mb-4 w-16 h-16 text-yellow-400 dark:text-gray-200"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                        </path>
                                                    </svg>
                                                    <p
                                                        class="my-5 text-md font-normal text-gray-500 dark:text-gray-400">
                                                        Are you sure you want to do this?
                                                    </p>
                                                    <button
                                                        data-modal-toggle="confirmBox{{ $loop->index ?? ($loop ?? 'one') }}"
                                                        type="button"
                                                        wire:click.prevent="DeleteRole({{ $role->id }})"
                                                        class="btn-sm btn-red mr-2">
                                                        Yes, I'm sure
                                                    </button>
                                                    <button
                                                        data-modal-toggle="confirmBox{{ $loop->index ?? ($loop ?? 'one') }}"
                                                        type="button" class="btn-sm btn-gray">No, cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>

            </div>
        </div>
    </div>
</div>
