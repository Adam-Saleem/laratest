<?php

namespace Corals\Modules\Medical;

use Corals\Foundation\Providers\BasePackageServiceProvider;
use Corals\Modules\Medical\Facades\Medical;
use Corals\Modules\Medical\Models\Patient;
use Corals\Modules\Medical\Providers\MedicalAuthServiceProvider;
use Corals\Modules\Medical\Providers\MedicalObserverServiceProvider;
use Corals\Modules\Medical\Providers\MedicalRouteServiceProvider;
use Corals\Settings\Facades\Modules;
use Corals\Settings\Facades\Settings;
use Illuminate\Foundation\AliasLoader;

class MedicalServiceProvider extends BasePackageServiceProvider
{
    protected $defer = true;
    /**
     * @var
     */
    protected $packageCode = 'corals-medical';

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function bootPackage()
    {
        // Load view
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'Medical');

        // Load translation
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'Medical');

        // Load migrations
        //        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $this->registerCustomFieldsModels();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function registerPackage()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/medical.php', 'medical');

        $this->app->register(MedicalRouteServiceProvider::class);
        $this->app->register(MedicalAuthServiceProvider::class);
        $this->app->register(MedicalObserverServiceProvider::class);

        $this->app->booted(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Medical', Medical::class);
        });
    }

    protected function registerCustomFieldsModels()
    {
        Settings::addCustomFieldModel(Patient::class);
    }

    public function registerModulesPackages()
    {
        Modules::addModulesPackages('corals/medical');
    }
}
