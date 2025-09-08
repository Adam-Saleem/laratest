<?php

namespace Corals\Modules\Medical\Transformers\API;

use Corals\Foundation\Transformers\FractalPresenter;

class PatientPresenter extends FractalPresenter
{
    /**
     * @return PatientTransformer
     */
    public function getTransformer()
    {
        return new PatientTransformer();
    }
}
