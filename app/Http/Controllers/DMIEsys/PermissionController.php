<?php

namespace App\Http\Controllers\DMIEsys;

use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        abort_unless(($this->can('change user permission')), 404);

        return view('dmiesys.human_resource.permissions');
    }
}
