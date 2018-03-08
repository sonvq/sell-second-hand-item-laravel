<?php

namespace Modules\Item\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Item\Entities\Item;
use App\Common\Helper;

class ItemSearchTransformer extends TransformerAbstract implements ItemSearchTransformerInterface {

    /**
     * Turn this item object into a generic array.
     *
     * @param $item
     * @return array
     */
    public function transform(Item $item) {
               
        return [
            'id' => (int) $item->id,        
            'title' => (string) $item->title,                
            'description' => (string) $item->description,                                
        ];
    }
}                           