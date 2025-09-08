<?php

namespace Corals\Modules\Medical\Transformers\API;

use Corals\Foundation\Transformers\APIBaseTransformer;
use Corals\Modules\Medical\Models\Patient;

class PatientTransformer extends APIBaseTransformer
{
    /**
     * @param Patient $patient
     * @return array
     * @throws \Throwable
     */
    public function transform(Patient $patient)
    {
        $transformedArray = [
            'id' => $patient->id,
            'name' => $patient->name,
            'created_at' => format_date($patient->created_at),
            'updated_at' => format_date($patient->updated_at),
        ];

        return parent::transformResponse($transformedArray);
    }
}
