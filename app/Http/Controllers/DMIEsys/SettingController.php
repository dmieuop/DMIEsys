<?php

namespace App\Http\Controllers\DMIEsys;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        abort_unless(($this->can('set pg registration')), 404);

        $settings = Setting::all(['key', 'value', 'bool']);

        $years = [];
        $pg_intake_year = null;
        $pg_application_open_date = null;
        $pg_application_close_date = null;
        $pg_emgt_offer = null;
        $pg_meng_offer = null;

        foreach ($settings as $setting) {
            if ($setting->key == 'pg-intake-year') {
                $pg_intake_year = $setting->value;
            }
            if ($setting->key == 'pg-application-open-date') {
                $pg_application_open_date = $setting->value;
            }
            if ($setting->key == 'pg-application-close-date') {
                $pg_application_close_date = $setting->value;
            }
            if ($setting->key == 'pg-emgt-offer') {
                $pg_emgt_offer = $setting->bool;
            }
            if ($setting->key == 'pg-meng-offer') {
                $pg_meng_offer = $setting->bool;
            }
        }

        for ($i = -1; $i < 5; $i++) {
            array_push($years, date('Y', time()) + $i);
        }

        return view('dmiesys.general.settings', compact('pg_intake_year', 'pg_application_open_date', 'pg_application_close_date', 'pg_emgt_offer', 'pg_meng_offer', 'years'));
    }

    /**
     * @param \App\Models\Setting $setting
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Setting $setting)
    {
        abort_unless(($this->can('set pg registration')), 404);

        try {
            $setting->value = $request['value'] ?? null;
            $setting->bool = $request['bool'] ?? null;
            $setting->save();
            $this->passed('system settings was changed');
            return back()->with('toast_success', 'Setting saved successfully!');
        } catch (\Throwable $th) {
            $this->failed($th);
            return back()->withErrors("There was a problem, please check the logs to see more about this!");
        }
    }
}
