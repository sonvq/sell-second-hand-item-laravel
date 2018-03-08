<?php

namespace Modules\Subcategory\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateSubcategoryRequest extends BaseFormRequest
{
    public function rules()
    {
        $subcategory = $this->route()->parameters()['subcategory'];
        
        return [
            'name' => 'required|max:255|unique:subcategory__subcategories,name,' . $subcategory->id,
            'category_id' => 'required|exists:category__categories,id',
            'status' => 'required|in:draft,publish'
        ];
    }

    public function translationRules()
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

    public function translationMessages()
    {
        return [];
    }
}
