<?php

namespace Modules\Notify\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateNotifyRequest extends BaseFormRequest
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
