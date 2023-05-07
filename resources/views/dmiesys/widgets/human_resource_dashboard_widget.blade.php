<div class="flex flex-wrap">

    @if (auth()->user()->hasRole('Head of the Department') ||
    auth()->user()->canAny(['add new hod', 'add user', 'see user', 'edit user', 'deactivate user', 'change user role']))
    <x-tile icon="person-plus" route="user-profile.create">
        Add/ Edit Users
    </x-tile>
    @endif

    @can('change user permission')
    <x-tile icon="key" route="user-permissions.index">
        User Permissions
    </x-tile>
    @endcan

</div>