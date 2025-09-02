<?php

namespace Corals\Modules\UtilityComment\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class CommentPresenter extends FractalPresenter
{
    /**
     * @param array $extras
     * @return CommentTransformer|\League\Fractal\TransformerAbstract
     */
    public function getTransformer($extras = [])
    {
        return new CommentTransformer($extras);
    }
}
