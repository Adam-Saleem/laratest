<?php

namespace Corals\Modules\Medical\Providers;

use Corals\Modules\Medical\Models\City;
use Corals\Modules\Medical\Models\Patient;
use Corals\Modules\Medical\Models\Village;
use Corals\Modules\Medical\Policies\CityPolicy;
use Corals\Modules\Medical\Policies\PatientPolicy;
use Corals\Modules\Medical\Policies\VillagePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class MedicalAuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Patient::class => PatientPolicy::class,
        City::class => CityPolicy::class,
        Village::class => VillagePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
