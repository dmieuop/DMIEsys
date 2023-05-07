<div class="flex flex-wrap">

    @if (auth()->user()->active_status)
    <x-tile icon="card-heading" route="forum.index">
        DMIEsys Forum
    </x-tile>
    @endif

    {{-- @canany(['manage dmielib', 'see dmielib', 'access dmielib'])
    @include('components.tile', [
    'route' => 'manage.students',
    'name' => 'DMIElib',
    'icon' => 'book',
    ])
    @endcan --}}

    @canany(['manage pg registration', 'see pg registration'])
    <x-tile icon="vector-pen" route="pg-registrations.index">
        PG Admin
    </x-tile>
    @endcan

    @canany(['set pg registration'])
    <x-tile icon="tools" route="settings.index">
        Settings
    </x-tile>
    @endcan

    {{-- @canany(['send update emails'])
    @include('components.tile', [
    'route' => 'sendemail',
    'name' => 'Send Emails',
    'icon' => 'envelope',
    ])
    @endcan --}}

    @if (auth()->user()->active_status)
    <x-tile icon="list-ul" route="changelog">
        Changelog
    </x-tile>
    @endif

    @can('see logs')
    <x-tile icon="fingerprint" route="logs">
        Logs
    </x-tile>
    @endcan

</div>