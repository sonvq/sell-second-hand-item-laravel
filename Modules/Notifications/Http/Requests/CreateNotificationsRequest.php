<?php

namespace Modules\Notifications\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateNotificationsRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'status' => 'required|in:draft,published,scheduled',
            'channels' => 'required|in:sms,email,in_app_notification',
            'schedule_date_from' => 'required_if:status,scheduled',
            'schedule_date_to' => 'required_if:status,scheduled|after_field:schedule_date_from',
            'broadcast_id' => 'required|exists:broadcast__broadcasts,id'
        ];
    }


    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'schedule_date_to.after_field' => 'Schedule date to must be after schedule date from'
        ];
    }

}
