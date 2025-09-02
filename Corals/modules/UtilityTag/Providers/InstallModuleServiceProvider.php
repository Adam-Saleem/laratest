<?php

namespace Corals\Modules\UtilityTag\Providers;

use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;
use Corals\Modules\UtilityTag\database\migrations\CreateTagTables;
use Corals\Modules\UtilityTag\database\seeds\UtilityTagDatabaseSeeder;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected $migrations = [
        CreateTagTables::class,
    ];

    protected function providerBooted()
    {
        $this->createSchema();

        $utilityTagDatabaseSeeder = new UtilityTagDatabaseSeeder();

        $utilityTagDatabaseSeeder->run();
    }
}
