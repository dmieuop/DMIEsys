<?php

namespace App\Http\Controllers\DMIEsys;

use App\Http\Controllers\Controller;

class PgStudentController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        abort_unless(($this->can('see pg registration')), 404);

        return view('dmiesys.general.pg-admin');
    }
}
