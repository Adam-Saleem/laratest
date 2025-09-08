<?php

namespace Corals\Modules\Medical\Observers;

use Corals\Modules\Medical\Models\Village;

class VillageObserver
{
    /**
     * @param Village $village
     * @return void
     */
    public function created(Village $village)
    {
    }
}