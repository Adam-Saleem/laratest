<?php

namespace Corals\Modules\Medical\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class CityPresenter extends FractalPresenter
{
    /**
     * @return CityTransformer
     */
    public function getTransformer($extras = [])
    {
        return new CityTransformer($extras);
    }
}