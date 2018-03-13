<?php

namespace Modules\Mobilelog\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateMobilelogRequest extends BaseFormRequest
{
    public function rules()
    {
        return [];
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
