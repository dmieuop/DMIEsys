<?php

namespace App\Http\Controllers\DMIEsys;

use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    public function index()
    {
        if (auth()->user()->newuser) {
            return view('welcome');
        }
        /* This is the default view that is loaded when the user logs in. */
        return view('dashboard');
    }


    public function manageCourses()
    {
        /* This is checking if the user has any of the permissions listed in the array. If they do, returns the view. If not, it returns a 404 error. */
        abort_unless(($this->canAny(['add base course', 'see base course', 'edit base course', 'delete base course', 'add course', 'see course', 'edit course', 'delete course'])), 404);
        return view('dmiesys.academics.manage-courses');
    }


    public function manageStudents()
    {
        /* This is checking if the user has any of the permissions listed in the array. If they do, returns the view. If not, it returns a 404 error. */
        abort_unless(($this->canAny(['add student', 'see student', 'edit student', 'delete student'])), 404);
        return view('dmiesys.academics.manage-students');
    }

    public function studentAffairs()
    {
        /* This is getting the user that is currently logged in. */
        $user = User::find(auth()->user()->id);
        /* This is checking if the user is the Head of the Department or has any of the permissions listed in the array. If they do, returns the view. If not, it returns a 404 error. */
        if (!($user->hasRole('Head of the Department')) && !($this->canAny(['add student advisor', 'student counselor', 'add advisory comments']))) {
            abort(404);
        }
        /* This is returning the view for the student affairs page. */
        return view('dmiesys.academics.student-affairs');
    }

    public function manageMarks()
    {
        /* This is checking if the user has any of the permissions listed in the array. If they do, returns the view. If not, it returns a 404 error. */
        abort_unless(($this->canAny(['add mark', 'see mark', 'edit mark', 'delete mark'])), 404);
        return view('dmiesys.academics.manage-marks');
    }

    public function studentAttainment()
    {
        /* This is checking if the user has any of the permissions listed in the array. If they do, returns the view. If not, it returns a 404 error. */
        abort_unless(($this->canAny(['see attainment report', 'see ilo achievement'])), 404);
        return view('dmiesys.academics.student-attainment');
    }

    public function manageLabs()
    {
        /* This is checking if the user has any of the permissions listed in the array. If they do,
        returns the view. If not, it returns a 404 error. */
        abort_unless(($this->canAny(['add laboratory', 'see laboratory', 'edit laboratory', 'delete laboratory'])), 404);
        return view('dmiesys.laboratories.manage-labs');
    }

    public function manageMachines()
    {
        /* This is checking if the user has any of the permissions listed in the array. If they do,
        returns the view. If not, it returns a 404 error. */
        abort_unless(($this->canAny(['add machine', 'see machine', 'edit machine', 'delete machine', 'add maintenance', 'see maintenance', 'edit maintenance', 'delete maintenance'])), 404);
        return view('dmiesys.laboratories.manage-machines');
    }

    public function pgAdmin()
    {
        /* This is checking if the user has any of the permissions listed in the array. If they do,
        returns the view. If not, it returns a 404 error. */
        abort_unless(($this->canAny(['manage pg registration', 'see pg registration'])), 404);
        return view('dmiesys.general.pg-admin');
    }

    public function viewLogs()
    {
        /* This is checking if the user has the permission to see logs. If they do, it returns the
        view. If not, it returns a 404 error. */
        abort_unless(($this->can('see logs')), 404);
        /* This is getting the last 50 logs from the database and ordering them by the id in descending
        order. */
        $logs = Log::orderByDesc('id')->simplePaginate(50);
        /* This is getting the last 50 authentication logs from the database and ordering them by the
        login_at in descending order. */
        $auths = DB::table('authentication_log')
            ->join('users', 'authentication_log.authenticatable_id', '=', 'users.id')
            ->orderByDesc('login_at')
            ->select('users.name', 'users.title', 'authentication_log.*')
            ->take(50)->get();
        return view('dmiesys.general.logs', compact('logs', 'auths'));
        /* This is returning the view for the logs page and passing the logs and auths variables to the
        view. */
    }
}
