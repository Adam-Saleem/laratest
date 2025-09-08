<?php

namespace Corals\Modules\Medical\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Medical\Models\Village;

class VillageTransformer extends BaseTransformer
{
    public function __construct($extras = [])
    {
        $this->resource_url = config('medical.models.village.resource_url');

        parent::__construct($extras);
    }

    /**
     * @param Village $village
     * @return array
     * @throws \Throwable
     */
    public function transform(Village $village)
    {
        $show_url = $village->getShowURL();

        $transformedArray = [
            'id' => $village->id,
            'name' => HtmlElement('a', ['href' => $village->getShowURL()], $village->name),
            'city_name' => $village->city ? HtmlElement('a', ['href' => $village->city->getShowURL()], $village->city->name) : '-',
            'created_at' => format_date($village->created_at),
            'updated_at' => format_date($village->updated_at),
            'action' => $this->actions($village),
        ];

        return parent::transformResponse($transformedArray);
    }
}