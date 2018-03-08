<?php

namespace Modules\Appuser\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateAppuserRequest extends BaseFormRequest
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
