<?php

namespace Corals\Modules\Medical\Providers;

use Corals\Foundation\Providers\BaseUninstallModuleServiceProvider;
use Corals\Modules\Medical\database\migrations\MedicalTables;
use Corals\Modules\Medical\database\seeds\MedicalDatabaseSeeder;

class UninstallModuleServiceProvider extends BaseUninstallModuleServiceProvider
{
    protected $migrations = [
        MedicalTables::class,
    ];

    protected function providerBooted()
    {
        $this->dropSchema();

        $medicalDatabaseSeeder = new MedicalDatabaseSeeder();

        $medicalDatabaseSeeder->rollback();
    }
}
