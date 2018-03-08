<?php

namespace Modules\Reporting\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateReportingRequest extends BaseFormRequest
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
