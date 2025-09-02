<?php

namespace Corals\Modules\UtilityComment\Providers;

use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;
use Corals\Modules\UtilityComment\database\migrations\CreateCommentsTable;
use Corals\Modules\UtilityComment\database\seeds\UtilityCommentDatabaseSeeder;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected $migrations = [
        CreateCommentsTable::class,
    ];

    protected function providerBooted()
    {
        $this->createSchema();

        $utilityCommentDatabaseSeeder = new UtilityCommentDatabaseSeeder();

        $utilityCommentDatabaseSeeder->run();
    }
}
