<?php

namespace Modules\Item\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateItemRequest extends BaseFormRequest
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
