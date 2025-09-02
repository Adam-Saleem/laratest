<?php

namespace Corals\Modules\UtilityTag\Facades;

use Illuminate\Support\Facades\Facade;

class Tag extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return \Corals\Modules\UtilityTag\Classes\TagManager::class;
    }
}
