<?php

namespace Modules\Receipt\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateReceiptRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'appuser_id' => 'required|exists:appuser__appusers,id',
            'item_id' => 'required|exists:item__items,id',
            'total_promo_days' => 'integer|min:1',
            'payment_mode' => 'required|in:otc,bank_transfer,visa,master,paypal,mpu,mobile_payment',
            'remarks' => 'required',
            'transaction_ref_id' => 'required_if:transaction_type,credit',
            'transaction_type' => 'required|in:credit,debit',
            'amount_due' => 'numeric|min:0|max:9999999999.99',
            'promo_period_from' => '',
            'promo_period_to' => 'after_field:promo_period_from'
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'appuser_id.exists' => 'Please select a valid phone number',
            'item_id.exists' => 'Please select a valid item',
            'promo_period_to.after_field' => 'Promo period to must be after promo period from',
            'amount_due.max' => "The amount due may not be greater than 9,999,999,999.99."
        ];
    }
}
