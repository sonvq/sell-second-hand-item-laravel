<?php

namespace Modules\Subcategory\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateSubcategoryRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|max:255|unique:subcategory__subcategories,name',
            'category_id' => 'required|exists:category__categories,id',
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
