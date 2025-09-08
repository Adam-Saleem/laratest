<?php

namespace Corals\Modules\Medical\Providers;

use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;
use Corals\Modules\Medical\database\migrations\MedicalTables;
use Corals\Modules\Medical\database\seeds\MedicalDatabaseSeeder;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected $module_public_path = __DIR__ . '/../public';

    protected $migrations = [
        MedicalTables::class,
    ];

    protected function providerBooted()
    {
        $this->createSchema();

        $medicalDatabaseSeeder = new MedicalDatabaseSeeder();

        $medicalDatabaseSeeder->run();
    }
}
