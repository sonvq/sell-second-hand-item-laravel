<?php

namespace Modules\Message\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateMessageRequest extends BaseFormRequest
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
