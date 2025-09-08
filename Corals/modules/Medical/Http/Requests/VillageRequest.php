<?php

namespace Corals\Modules\Medical\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Medical\Models\Village;

class VillageRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Village::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Village::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
                'name' => 'required|string|max:255',
                'city_id' => 'required|exists:medical_cities,id',
            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, [
                'name' => 'required|string|max:255|unique:medical_villages,name',
            ]);
        }

        if ($this->isUpdate()) {
            $village = $this->route('village');

            $rules = array_merge($rules, [
                'name' => 'required|string|max:255|unique:medical_villages,name,' . $village->id,
            ]);
        }

        return $rules;
    }
}