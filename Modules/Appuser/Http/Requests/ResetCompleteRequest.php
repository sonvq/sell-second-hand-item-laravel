<?php

namespace Modules\Appuser\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetCompleteRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => [
                'required',
                'max:255',
                'confirmed',
                'regex:/^(?=.*[A-Z])(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{6,12}$/',
                'min:6',
                'max:12'
            ],  
            'password_confirmation' => 'required'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'password.regex' => 'Password need at least one capital, one special, between 6 and 12 character'
        ];
    }
}
