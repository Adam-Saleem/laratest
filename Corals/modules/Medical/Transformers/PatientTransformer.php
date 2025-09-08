<?php

namespace Corals\Modules\Medical\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Medical\Models\Patient;

class PatientTransformer extends BaseTransformer
{
    public function __construct($extras = [])
    {
        $this->resource_url = config('medical.models.patient.resource_url');

        parent::__construct($extras);
    }

    /**
     * @param Patient $patient
     * @return array
     * @throws \Throwable
     */
    public function transform(Patient $patient)
    {
        $show_url = $patient->getShowURL();

        $transformedArray = [
            'id' => $patient->id,
            'name' => HtmlElement('a', ['href' => $patient->getShowURL()], $patient->name),
            'id_number' => $patient->id_number ?: '-',
            'age' => $patient->age ?: '-',
            'gender' => $patient->gender ? $patient->gender->badge() : '-',
            'phone' => $patient->phone ?: '-',
            'address' => $patient->full_address ?: '-',
            'marital' => $patient->marital ? $patient->marital->badge() : '-',
            'created_at' => format_date($patient->created_at),
            'updated_at' => format_date($patient->updated_at),
            'action' => $this->actions($patient),
        ];

        return parent::transformResponse($transformedArray);
    }
}
