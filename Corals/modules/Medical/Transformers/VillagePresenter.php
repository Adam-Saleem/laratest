<?php

namespace Corals\Modules\Medical\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class VillagePresenter extends FractalPresenter
{
    /**
     * @return VillageTransformer
     */
    public function getTransformer($extras = [])
    {
        return new VillageTransformer($extras);
    }
}