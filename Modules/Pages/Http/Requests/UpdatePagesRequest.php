<?php

namespace Modules\Pages\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdatePagesRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'page_type' => 'required|in:landing_page,about_us,terms_conditions',
            'description' => 'required',
            'status' => 'required|in:draft,publish'
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
