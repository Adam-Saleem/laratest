<?php

namespace Corals\Modules\Medical\Observers;

use Corals\Modules\Medical\Models\Patient;

class PatientObserver
{
    /**
     * @param Patient $patient
     */
    public function created(Patient $patient)
    {
    }
}
