<?php

namespace Modules\Promote\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Promote\Entities\Promote;
use App\Common\Helper;

class PromoteTransformer extends TransformerAbstract implements PromoteTransformerInterface {

    /**
     * Turn this item object into a generic array.
     *
     * @param $item
     * @return array
     */
    public function transform(Promote $item) {        
        
        $text_display = 'MMK ' . $item->price_amount . ' for ' . $item->number_of_date_expired . ' days';
        return [
            'id' => (int) $item->id,
            'price_amount' => (integer) $item->price_amount,
            'number_of_date_expired' => (integer) $item->number_of_date_expired,
            'text_display' => (string) $text_display,
            
            'created_at' => (string) $item->created_at,
            'updated_at' => (string) $item->updated_at,
        ];
    }
}                           