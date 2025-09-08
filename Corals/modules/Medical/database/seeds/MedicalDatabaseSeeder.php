<?php

namespace Corals\Modules\Medical\database\seeds;

use Corals\Menu\Models\Menu;
use Corals\Settings\Models\Setting;
use Corals\User\Models\Permission;
use Illuminate\Database\Seeder;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MedicalDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(MedicalPermissionsDatabaseSeeder::class);
        $this->call(MedicalMenuDatabaseSeeder::class);
        $this->call(MedicalSettingsDatabaseSeeder::class);
        $this->call(MedicalDataDatabaseSeeder::class);
    }

    public function rollback()
    {
        Permission::where('name', 'like', 'Medical::%')->delete();

        Menu::where('key', 'medical')
            ->orWhere('active_menu_url', 'like', 'medical%')
            ->orWhere('url', 'like', 'medical%')
            ->delete();

        Setting::where('category', 'Medical')->delete();

        Media::whereIn('collection_name', ['medical-media-collection'])->delete();
    }
}
