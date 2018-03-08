<?php

namespace Modules\Promote\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreatePromoteRequest extends BaseFormRequest
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
