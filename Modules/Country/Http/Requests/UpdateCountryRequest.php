<?php

namespace Modules\Country\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateCountryRequest extends BaseFormRequest
{
    public function rules()
    {
        $country = $this->route()->parameters()['country'];
        return [
            'name' => 'required|max:255|unique:country__countries,name,' . $country->id
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
