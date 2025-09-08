<?php

namespace Corals\Modules\Medical\Observers;

use Corals\Modules\Medical\Models\City;

class CityObserver
{
    /**
     * @param City $city
     */
    public function created(City $city)
    {
    }
}