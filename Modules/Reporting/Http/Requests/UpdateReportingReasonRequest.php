<?php

namespace Modules\Reporting\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateReportingReasonRequest extends BaseFormRequest
{
    public function rules()
    {
        $reporting_reason = $this->route()->parameters()['reporting_reason'];
        return [
            'name' => 'required|max:255|unique:reporting__reasons,name,' . $reporting_reason->id
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
