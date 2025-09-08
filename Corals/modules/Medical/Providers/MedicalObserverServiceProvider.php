<?php

namespace Corals\Modules\Medical\Providers;

use Corals\Modules\Medical\Models\City;
use Corals\Modules\Medical\Models\Patient;
use Corals\Modules\Medical\Models\Village;
use Corals\Modules\Medical\Observers\CityObserver;
use Corals\Modules\Medical\Observers\PatientObserver;
use Corals\Modules\Medical\Observers\VillageObserver;
use Illuminate\Support\ServiceProvider;

class MedicalObserverServiceProvider extends ServiceProvider
{
    /**
     * Register Observers
     */
    public function boot()
    {
        Patient::observe(PatientObserver::class);
        City::observe(CityObserver::class);
        Village::observe(VillageObserver::class);
    }
}
