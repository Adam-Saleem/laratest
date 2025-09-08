<?php

namespace Corals\Modules\Medical\database\seeds;

use Carbon\Carbon;
use Corals\Settings\Facades\Settings;
use Illuminate\Database\Seeder;

class MedicalSettingsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settings::set('active_admin_theme', config('medical.active_theme'));
        Settings::set('site_name', 'Medical');
        Settings::set('registration_enabled', 'false');
        Settings::set('supported_languages', [
            "en" => 'english',
        ]);

        Settings::set('login_background', 'background: url(/uploads/settings/site_logo.png);
        background-repeat: no-repeat;
        background-size: 25%;
        background-position: center center;
        background-color: #F0FFFF;');

        \DB::table('settings')->insert([
            [
                'code' => 'medical_setting',
                'type' => 'TEXT',
                'category' => 'Medical',
                'label' => 'Medical setting',
                'value' => 'medical',
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
