<?php

namespace Corals\Modules\UtilitySEO\Providers;

use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;
use Corals\Modules\UtilitySEO\database\migrations\CreateSEOItemsTable;
use Corals\Modules\UtilitySEO\database\seeds\UtilitySEODatabaseSeeder;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected $migrations = [
        CreateSEOItemsTable::class,
    ];

    protected function providerBooted()
    {
        $this->createSchema();

        $utilitySEODatabaseSeeder = new UtilitySEODatabaseSeeder();

        $utilitySEODatabaseSeeder->run();
    }
}
