<?php

namespace Corals\Modules\UtilitySEO\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class SEOItemPresenter extends FractalPresenter
{
    /**
     * @param array $extras
     * @return SEOItemTransformer|\League\Fractal\TransformerAbstract
     */
    public function getTransformer($extras = [])
    {
        return new SEOItemTransformer($extras);
    }
}
