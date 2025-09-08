<?php

namespace Corals\Modules\Medical\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Medical\Models\City;

class CityTransformer extends BaseTransformer
{
    public function __construct($extras = [])
    {
        $this->resource_url = config('medical.models.city.resource_url');

        parent::__construct($extras);
    }

    /**
     * @param City $city
     * @return array
     * @throws \Throwable
     */
    public function transform(City $city)
    {
        $show_url = $city->getShowURL();

        $transformedArray = [
            'id' => $city->id,
            'name' => HtmlElement('a', ['href' => $city->getShowURL()], $city->name),
            'villages_count' => $city->villages_count ?? 0,
            'created_at' => format_date($city->created_at),
            'updated_at' => format_date($city->updated_at),
            'action' => $this->actions($city),
        ];

        return parent::transformResponse($transformedArray);
    }
}