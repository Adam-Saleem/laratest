<?php

namespace Corals\Modules\UtilitySEO\Facades;

use Illuminate\Support\Facades\Facade;

class SEOItems extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return \Corals\Modules\UtilitySEO\Classes\SEOItems::class;
    }
}
