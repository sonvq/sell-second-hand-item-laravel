<?php

namespace Modules\Category\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;
use Illuminate\Http\Request;
use Modules\Category\Entities\Category;

class UpdateCategoryRequest extends BaseFormRequest
{
    public function rules(Request $request)
    {
        
        $category = $this->route()->parameters()['category'];
        
        return [
            'name' => 'required|max:255|unique:category__categories,name,' . $category->id,
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
