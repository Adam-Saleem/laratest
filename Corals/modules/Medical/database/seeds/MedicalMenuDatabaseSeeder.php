<?php

namespace Corals\Modules\Medical\database\seeds;

use Corals\Modules\Medical\Classes\MedicalRoles;
use Corals\User\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicalMenuDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $medical_menu_id = \DB::table('menus')->insertGetId([
            'parent_id' => 1,// admin
            'key' => 'medical',
            'url' => null,
            'active_menu_url' => 'patients*',
            'name' => 'Medical',
            'description' => 'Medical Menu Item',
            'icon' => 'fa fa-globe',
            'target' => null, 'roles' => '["1"]',
            'order' => 0,
        ]);

        $medicalAdmin = Role::findByName(MedicalRoles::MEDICAL_ADMIN);

        $horizontalConfig = [
            'parent_id' => 1,
            'roles' => $medicalAdmin->id,
        ];

        $verticalConfig = [
            'parent_id' => $medical_menu_id,
            'roles' => 1
        ];

        $menus = [
            [
                'key' => null,
                'url' => config('medical.models.patient.resource_url'),
                'active_menu_url' => config('medical.models.patient.resource_url') . '*',
                'name' => 'Patients',
                'description' => 'Patients List Menu Item',
                'icon' => 'fa fa-user',
                'target' => null,
                'order' => 0,
            ],
            [
                'key' => null,
                'url' => config('medical.models.city.resource_url'),
                'active_menu_url' => config('medical.models.city.resource_url') . '*',
                'name' => 'Cities',
                'description' => 'Cities List Menu Item',
                'icon' => 'fa fa-building',
                'target' => null,
                'order' => 1,
            ],
            [
                'key' => null,
                'url' => config('medical.models.village.resource_url'),
                'active_menu_url' => config('medical.models.village.resource_url') . '*',
                'name' => 'Villages',
                'description' => 'Villages List Menu Item',
                'icon' => 'fa fa-home',
                'target' => null,
                'order' => 2,
            ],
        ];

        // seed children menu
        foreach ($menus as $menuItem) {
            $menuItems [] = array_merge($horizontalConfig, $menuItem);
            $menuItems [] = array_merge($menuItem, $verticalConfig);
        }

        DB::table('menus')->insert(
            $menuItems
        );
    }
}
