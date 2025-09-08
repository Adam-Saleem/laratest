<?php

namespace Corals\Modules\Medical\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class PatientPresenter extends FractalPresenter
{
    /**
     * @return PatientTransformer
     */
    public function getTransformer($extras = [])
    {
        return new PatientTransformer($extras);
    }
}
