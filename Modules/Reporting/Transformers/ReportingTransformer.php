<?php

namespace Modules\Reporting\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Reporting\Entities\Reporting;
use App\Common\Helper;

class ReportingTransformer extends TransformerAbstract implements ReportingTransformerInterface {

    /**
     * Turn this item object into a generic array.
     *
     * @param $item
     * @return array
     */
    public function transform(Reporting $item) {        
        
        return [
            'id' => (int) $item->id,
            'sender_id' => (int) $item->sender_id,
            'receiver_id' => (int) $item->receiver_id,
            'reporting_reason_id' => (int) $item->reporting_reason_id,                
            'item_id' => (int) $item->item_id,                    
            
            'sender' => $item->sender,
            'receiver' => $item->receiver,
            'reporting_reason' => $item->reporting_reason,
            'item' => $item->item,
            
            'created_at' => (string) $item->created_at,
            'updated_at' => (string) $item->updated_at,
        ];
    }
}                           