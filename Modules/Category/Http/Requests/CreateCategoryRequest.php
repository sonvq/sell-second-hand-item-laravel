<?php

namespace Modules\Category\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateCategoryRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|max:255|unique:category__categories',
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
