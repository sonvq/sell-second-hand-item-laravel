<?php

namespace Modules\Mobilelog\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Mobilelog\Entities\Mobilelog;
use App\Common\Helper;

class MobilelogTransformer extends TransformerAbstract implements MobilelogTransformerInterface {

    /**
     * Turn this item object into a generic array.
     *
     * @param $item
     * @return array
     */
    public function transform(Mobilelog $item) {
               
        return [
            'id' => (int) $item->id,        
            'content' => (string) $item->content,                
            'file_name' => (string) $item->file_name,   
            'function_name' => (string) $item->function_name,   
            'appuser_id' => (string) $item->appuser_id,   
            'appuser' => $item->appuser,
            
            'created_at' => (string) $item->created_at,
            'updated_at' => (string) $item->updated_at,
        ];
    }
}                           