<?php

namespace Corals\Modules\UtilityComment\Providers;

use Corals\Foundation\Providers\BaseUninstallModuleServiceProvider;
use Corals\Modules\UtilityComment\database\migrations\CreateCommentsTable;
use Corals\Modules\UtilityComment\database\seeds\UtilityCommentDatabaseSeeder;

class UninstallModuleServiceProvider extends BaseUninstallModuleServiceProvider
{
    protected $migrations = [
        CreateCommentsTable::class,
    ];

    protected function providerBooted()
    {
        $this->dropSchema();

        $utilityCommentDatabaseSeeder = new UtilityCommentDatabaseSeeder();

        $utilityCommentDatabaseSeeder->rollback();
    }
}
