<?php

namespace Corals\Modules\Medical\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Medical\Models\City;

class CityRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(City::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(City::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
                'name' => 'required|string|max:255',
            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, [
                'name' => 'required|string|max:255|unique:medical_cities,name',
            ]);
        }

        if ($this->isUpdate()) {
            $city = $this->route('city');

            $rules = array_merge($rules, [
                'name' => 'required|string|max:255|unique:medical_cities,name,' . $city->id,
            ]);
        }

        return $rules;
    }
}