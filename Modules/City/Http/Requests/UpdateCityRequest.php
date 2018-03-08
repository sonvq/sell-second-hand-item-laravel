<?php

namespace Modules\City\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateCityRequest extends BaseFormRequest
{
    public function rules()
    {
        $city = $this->route()->parameters()['city'];
        return [
            'name' => 'required|max:255|unique:city__cities,name,' . $city->id,
            'country_id' => 'required|exists:country__countries,id'
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [];
    }

}
