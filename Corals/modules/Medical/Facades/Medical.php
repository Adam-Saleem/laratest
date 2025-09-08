<?php

namespace Corals\Modules\Medical\Facades;

use Illuminate\Support\Facades\Facade;

class Medical extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return \Corals\Modules\Medical\Classes\Medical::class;
    }
}
