<?php

namespace Corals\Modules\UtilitySEO\Providers;

use Corals\Foundation\Providers\BaseUninstallModuleServiceProvider;
use Corals\Modules\UtilitySEO\database\migrations\CreateSEOItemsTable;
use Corals\Modules\UtilitySEO\database\seeds\UtilitySEODatabaseSeeder;

class UninstallModuleServiceProvider extends BaseUninstallModuleServiceProvider
{
    protected $migrations = [
        CreateSEOItemsTable::class,
    ];

    protected function providerBooted()
    {
        $this->dropSchema();

        $utilitySEODatabaseSeeder = new UtilitySEODatabaseSeeder();

        $utilitySEODatabaseSeeder->rollback();
    }
}
