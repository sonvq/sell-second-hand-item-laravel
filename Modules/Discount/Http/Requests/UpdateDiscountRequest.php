<?php

namespace Modules\Discount\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateDiscountRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'discount_percent' => 'numeric|min:0|max:100'
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
