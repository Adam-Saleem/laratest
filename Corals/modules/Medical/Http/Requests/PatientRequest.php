<?php

namespace Corals\Modules\Medical\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Medical\Models\Patient;

class PatientRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Patient::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Patient::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, [
            ]);
        }

        if ($this->isUpdate()) {
            $patient = $this->route('patient');

            $rules = array_merge($rules, [
            ]);
        }

        return $rules;
    }
}
