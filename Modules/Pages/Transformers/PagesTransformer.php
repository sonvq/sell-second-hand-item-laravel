<?php

namespace Modules\Pages\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Pages\Entities\Pages;
use App\Common\Helper;


class PagesTransformer extends TransformerAbstract implements PagesTransformerInterface {

    /**
     * Turn this item object into a generic array.
     *
     * @param $item
     * @return array
     */
    public function transform(Pages $item) {        
        
        return [
            'id' => (int) $item->id,
            'page_type' => (string) $item->page_type,
            'description' => (string) $item->description,
            'status' => (string) $item->status,            
            
            'created_at' => (string) $item->created_at,
            'updated_at' => (string) $item->updated_at,
        ];
    }
}            
