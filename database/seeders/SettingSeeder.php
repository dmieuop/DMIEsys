<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{

    public function run()
    {
        Setting::create([
            'key' => 'pg-intake-year',
            'value' => '2000',
        ]);

        Setting::create([
            'key' => 'pg-application-open-date',
            'value' => '2000-01-01',
        ]);

        Setting::create([
            'key' => 'pg-application-close-date',
            'value' => '2000-01-31',
        ]);

        Setting::create([
            'key' => 'pg-emgt-offer',
            'bool' => true,
        ]);

        Setting::create([
            'key' => 'pg-meng-offer',
            'bool' => true,
        ]);
    }
}
