<?php

namespace Modules\Mobilelog\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateMobilelogRequest extends BaseFormRequest
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
