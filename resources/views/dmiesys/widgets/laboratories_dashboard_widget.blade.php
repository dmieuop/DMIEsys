<div class="flex flex-wrap">

    @canany(['add laboratory', 'see laboratory', 'edit laboratory', 'delete laboratory'])
    <x-tile icon="hospital" route="manage.labs">
        Manage Labs
    </x-tile>
    @endcan

    @canany(['add machine', 'see machine', 'edit machine', 'delete machine','add maintenance','see maintenance', 'edit
    maintenance', 'delete maintenance'])
    <x-tile icon="robot" route="manage.machines">
        Manage Machines
    </x-tile>
    @endcan

    @canany(['add inventory', 'see inventory', 'edit inventory', 'delete inventory'])
    <x-tile icon="table" route="inventory.index">
        Inventory
    </x-tile>
    @endcan


</div>