@extends('layouts.dmiesys.app')

@section('title', '| Changelog')
@section('back_page', 'Go back to Dashboard')
@section('back_link') {{ route('dashboard') }} @endsection

@section('content')

<div class="screen">

    <p class="mt-5 mb-8 text-3xl font-semibold dark:text-white">Changelog</p>

    <div class="prose prose-md">
        <div class="flex">
            <div class="text-2xl font-semibold text-black dark:text-white">v2.5</div>
            <span
                class="ml-5 mr-2 rounded-2xl rounded bg-purple-100 px-3 py-1.5 text-sm font-medium text-purple-800 dark:bg-purple-200 dark:text-purple-800">
                Feature release</span>
        </div>
        <div class="text-md dark:text-gray-400">June 30, 2023</div>
        <h3 class="dark:text-white">New additions</h3>
        <ul class="dark:text-gray-400">
            <li>
                Internal users now can book a facility.
            </li>
        </ul>
        <h3 class="dark:text-white">Changes</h3>
        <ul class="dark:text-gray-400">
            <li>
                Dark mode switcher is back with instant mode switching.
            </li>
        </ul>
        <h3 class="dark:text-white">Bug fixes</h3>
        <ul class="dark:text-gray-400">
            <li>
                Fixed a bug which caused 'add a new lab' button icon to disappear.
            </li>
        </ul>
    </div>
    <x-section-border />

    <div class="prose prose-md">
        <div class="flex">
            <div class="text-2xl font-semibold text-black dark:text-white">v2.4</div>
            <span
                class="ml-5 mr-2 rounded-2xl rounded bg-purple-100 px-3 py-1.5 text-sm font-medium text-purple-800 dark:bg-purple-200 dark:text-purple-800">
                Feature release</span>
        </div>
        <div class="text-md dark:text-gray-400">April 27, 2023</div>
        <h3 class="dark:text-white">Changes</h3>
        <ul class="dark:text-gray-400">
            <li>DMIEsys system now use Laravel 10.
            </li>
        </ul>
    </div>
    <x-section-border />

    <div class="prose prose-md">
        <div class="flex">
            <div class="text-2xl font-semibold text-black dark:text-white">v2.4.1</div>
            <span
                class="ml-5 mr-2 rounded-2xl rounded bg-red-100 px-3 py-1.5 text-sm font-medium text-red-800 dark:bg-red-200 dark:text-red-800">
                Bug fixing</span>
        </div>
        <div class="text-md dark:text-gray-400">March 13, 2023</div>
        <h3 class="dark:text-white">Bug fixes</h3>
        <ul class="dark:text-gray-400">
            <li>Fixed a bug that caused multiple emails to be sent to advisors in order to remind them to log comments.
            </li>
        </ul>
    </div>
    <x-section-border />

    <div class="prose prose-md">
        <div class="flex">
            <div class="text-2xl font-semibold text-black dark:text-white">v2.4</div>
            <span
                class="ml-5 mr-2 rounded-2xl rounded bg-purple-100 px-3 py-1.5 text-sm font-medium text-purple-800 dark:bg-purple-200 dark:text-purple-800">
                Feature release</span>
        </div>
        <div class="text-md dark:text-gray-400">February 23, 2023</div>
        <h3 class="dark:text-white">New additions</h3>
        <ul class="dark:text-gray-400">
            {{-- <li>(Student profile)</li> --}}
            {{-- <li>Users will receive an alert when the system is updated to a newer version.</li> --}}
            <li>Machine operators now can update regular maintenance when they do it.</li>
        </ul>
        <h3 class="dark:text-white">Changes</h3>
        <ul class="dark:text-gray-400">
            {{-- <li>(new notification system)</li> --}}
            <li>Back to the previous window now has an eye-catching yellow color.</li>
            <li>Student meeting reminder duration reduced to 1 month from the previous three months.</li>
            <li>Now, HOD will be alerted if an advisor misses meeting their student for two months.</li>
            <li>Dashbord icon color in light-mode change to nice blue color.</li>
            <li>Users can no longer switch to dark mode manually. Dark mode will auto-enable depending on your system
                theme settings.
            </li>
        </ul>
        <h3 class="dark:text-white">Bug fixes</h3>
        <ul class="dark:text-gray-400">
            <li>Fixed a bug that occurred when a new user signed up to the system.</li>
            <li>Fixed a bug that prevents users from changing their profile picture.</li>
        </ul>
    </div>
    <x-section-border />

    <div class="prose prose-md">
        <div class="flex">
            <div class="text-2xl font-semibold text-black dark:text-white">v2.3</div>
            <span
                class="ml-5 mr-2 rounded-2xl rounded bg-purple-100 px-3 py-1.5 text-sm font-medium text-purple-800 dark:bg-purple-200 dark:text-purple-800">
                Feature release</span>
        </div>
        <div class="text-md dark:text-gray-400">April 22, 2022</div>
        <h3 class="dark:text-white">New additions</h3>
        <ul class="dark:text-gray-400">
            <li>Added new component to interact with student for advisors. (Student Affairs)</li>
            <li>Users now can use both Email and Username to login.</li>
            <li>Users can toggle visibility of the password on the login page.</li>
            <li>Creating a course now require a google drive folder id.</li>
            <li>Instant notification alert added.</li>
        </ul>
        <h3 class="dark:text-white">Changes</h3>
        <ul class="dark:text-gray-400">
            <li>Old notification system got changed to new system wide enabled notifications. (click top right corner
                bell icon)</li>
            <li>Telescope feature got removed. (Admin feature only)</li>
            <li>Adding new inventory item window moved to new dedicated page.</li>
            <li>Inventory item property now can have a more styled text.</li>
            <li>In a message conversation latest messages will appear in the top.</li>
            <li>Users now can send more styled messages.</li>
        </ul>
        <h3 class="dark:text-white">Bug fixes</h3>
        <ul class="dark:text-gray-400">
            <li>Fixed a bug occured in showing a message.</li>
            <li>Fixed a error occured when accessing the profile page.</li>
            <li>Fixed a bug in user adding system.</li>
            <li>Fixed many minor server-side bugs.</li>
        </ul>
    </div>
    <x-section-border />

    <div class="prose prose-md">
        <div class="flex">
            <div class="text-2xl font-semibold text-black dark:text-white">v2.2</div>
            <span
                class="ml-5 mr-2 rounded-2xl rounded bg-purple-100 px-3 py-1.5 text-sm font-medium text-purple-800 dark:bg-purple-200 dark:text-purple-800">
                Feature release</span>
        </div>
        <div class="text-md dark:text-gray-400">March 31, 2022</div>
        <h3 class="dark:text-white">New additions</h3>
        <ul class="dark:text-gray-400">
            <li>Now user can upload a images for the inventory items.</li>
        </ul>
        <h3 class="dark:text-white">Changes</h3>
        <ul class="dark:text-gray-400">
            <li>New profile image upload now deletes the old profile image from the file server.</li>
            <li>Add/ Edit Users tab moved to the Human Resource panel.</li>
            <li>User Permissions tab moved to the Human Resource panel.</li>
        </ul>
        <h3 class="dark:text-white">Bug fixes</h3>
        <ul class="dark:text-gray-400">
            <li>Newly added users will not show up in the course creation page until they filled their profile
                informations.</li>
            <li>Newly added users will not show up in the maintenance schedule upload page until they filled their
                profile
                informations.</li>
        </ul>
    </div>
    <x-section-border />

    <div class="prose prose-md">
        <div class="flex">
            <div class="text-2xl font-semibold text-black dark:text-white">v2.1</div>
            <span
                class="ml-5 mr-2 rounded-2xl rounded bg-purple-100 px-3 py-1.5 text-sm font-medium text-purple-800 dark:bg-purple-200 dark:text-purple-800">
                Feature release</span>
        </div>
        <div class="text-md dark:text-gray-400">March 25, 2022</div>
        <h3 class="dark:text-white">New additions</h3>
        <ul class="dark:text-gray-400">
            <li>Added two-factor authentication facility for more secure user login. Goto profile page to enable.</li>
            <li>Users now can deactivate their accout from the profile page.</li>
            <li>Inventory Item information now can see in didicated page.</li>
        </ul>
    </div>
    <x-section-border />

    <div class="prose prose-md">
        <div class="flex">
            <div class="text-2xl font-semibold text-black dark:text-white">v2.0.1</div>
            <span
                class="ml-5 mr-2 rounded-2xl rounded bg-red-100 px-3 py-1.5 text-sm font-medium text-red-800 dark:bg-red-200 dark:text-red-800">
                Bug fixing</span>
        </div>
        <div class="text-md dark:text-gray-400">March 24, 2022</div>
        <h3 class="dark:text-white">Changes</h3>
        <ul class="dark:text-gray-400">
            <li>Inventory QR Code change from item code to url to view item information.</li>
        </ul>
        <h3 class="dark:text-white">Bug fixes</h3>
        <ul class="dark:text-gray-400">
            <li>Permission error in adding inventory items.</li>
            <li>UI error in student attainment report.</li>
        </ul>
    </div>
    <x-section-border />


    <div class="prose prose-md">
        <div class="flex">
            <div class="text-2xl font-semibold text-black dark:text-white">v2.0</div>
            <span
                class="ml-5 mr-2 rounded-2xl rounded bg-purple-100 px-3 py-1.5 text-sm font-medium text-purple-800 dark:bg-purple-200 dark:text-purple-800">
                Feature release</span>
        </div>
        <div class="text-md dark:text-gray-400">March 8, 2022</div>
        <h3 class="dark:text-white">New additions</h3>
        <ul class="dark:text-gray-400">
            <li>Google ReCapacha protection added.</li>
            <li>Inventory module added.</li>
            <li>Manage Labs module added.</li>
            <li>Manage Machines module added.</li>
            <li>DMIEsys Forum module added.</li>
            <li>Setting module added.</li>
            <li>Telescope module added.</li>
            <li>New system wide enable log keeping and aduting system added.</li>
            <li>Users now can switch to the dark mode.</li>
        </ul>
        <h3 class="dark:text-white">Changes</h3>
        <ul class="dark:text-gray-400">
            <li>New User interface support by Tailwind 3.0</li>
            <li>Role based permission system changed to more advanced permission system.</li>
            <li>New user messaging system with group chats.</li>
        </ul>
    </div>
    <x-section-border />

    <div class="prose prose-md">
        <div class="flex">
            <div class="text-2xl font-semibold text-black dark:text-white">v1.1</div>
            <span
                class="ml-5 mr-2 rounded-2xl rounded bg-purple-100 px-3 py-1.5 text-sm font-medium text-purple-800 dark:bg-purple-200 dark:text-purple-800">
                Feature release</span>
        </div>
        <div class="text-md dark:text-gray-400">October 20, 2021</div>
        <h3 class="dark:text-white">New additions</h3>
        <ul class="dark:text-gray-400">
            <li>Post-graduate student registration module added.</li>
        </ul>
        <h3 class="dark:text-white">Bug fixes</h3>
        <ul class="dark:text-gray-400">
            <li>Fixed a bug in student attainment report.</li>
        </ul>
    </div>
    <x-section-border />

    <div class="prose prose-md">
        <div class="flex">
            <div class="text-2xl font-semibold text-black dark:text-white">v1.0</div>
            <span
                class="ml-5 mr-2 rounded-2xl rounded bg-green-100 px-3 py-1.5 text-sm font-medium text-green-800 dark:bg-green-200 dark:text-green-800">
                First release</span>
        </div>
        <div class="text-md dark:text-gray-400">October 8, 2021</div>
        <h3 class="dark:text-white">New additions</h3>
        <ul class="dark:text-gray-400">
            <li>Manage Courses module added.</li>
            <li>Manage Marks module added.</li>
            <li>Manage Student module added.</li>
            <li>Student Attainment module added.</li>
            <li>User Management module added.</li>
            <li>User Messaging module added.</li>
        </ul>
    </div>
    <x-section-border />



</div>

@endsection