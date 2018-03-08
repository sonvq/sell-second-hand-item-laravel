<?php

namespace Modules\Broadcast\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateBroadcastRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'gender' => 'required',
//            'subcategories' => 'required',
            'age_band' => 'required',
            'cities' => 'required'
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
//            'subcategories.required' => 'The interest field is required'
        ];
    }

}
