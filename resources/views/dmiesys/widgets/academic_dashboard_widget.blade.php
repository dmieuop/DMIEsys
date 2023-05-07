<div class="flex flex-wrap">

    @canany(['add base course', 'see base course', 'edit base course', 'delete base course', 'add course', 'see course',
    'edit course', 'delete course'])
    <x-tile icon="journal-bookmark" route="manage.courses">
        Manage Courses
    </x-tile>
    @endcan

    @canany(['add student', 'see student', 'edit student', 'delete student'])
    <x-tile icon="person-rolodex" route="manage.students">
        Manage Students
    </x-tile>
    @endcan

    @if (auth()->user()->hasRole('Head of the Department') ||
    auth()->user()->canAny(['add student advisor', 'student counselor', 'add advisory comments']))
    <x-tile icon="check2-circle" route="student.affairs">
        Student Affairs
    </x-tile>
    @endif

    @canany(['add mark', 'see mark', 'edit mark', 'delete mark'])
    <x-tile icon="123" route="manage.marks">
        Manage Marks
    </x-tile>
    @endcan

    @canany(['see attainment report', 'see ilo achievement'])
    <x-tile icon="award" route="student.attainment">
        Student Attainment
    </x-tile>
    @endcan

</div>