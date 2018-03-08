<?php

namespace Modules\Email\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateEmailRequest extends BaseFormRequest
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
