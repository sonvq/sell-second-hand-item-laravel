<?php

namespace Modules\Reporting\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateReportingReasonRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|max:255|unique:reporting__reasons,name'
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
