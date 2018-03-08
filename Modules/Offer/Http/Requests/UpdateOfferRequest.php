<?php

namespace Modules\Offer\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateOfferRequest extends BaseFormRequest
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
