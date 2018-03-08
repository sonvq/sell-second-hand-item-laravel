<?php

namespace Modules\City\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateCityRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|max:255|unique:city__cities,name',
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
