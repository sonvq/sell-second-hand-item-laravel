<?php

namespace Modules\Message\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Message\Entities\Message;
use App\Common\Helper;


class MessageTransformer extends TransformerAbstract implements MessageTransformerInterface {

    /**
     * Turn this item object into a generic array.
     *
     * @param $item
     * @return array
     */
    public function transform(Message $item) {
        $itemObject = $item->item; 
        $itemGallery = $item->item->gallery;

        $sellerObject = $item->seller;
        if ($sellerObject) {
            $avatarSeller = $sellerObject->avatar_image->first();
            $sellerObject->avatar = $avatarSeller;
        }
                
        $buyerObject = $item->buyer;           
        if ($buyerObject) {
            $avatarBuyer = $buyerObject->avatar_image->first();
            $buyerObject->avatar = $avatarBuyer;
        }
        
        return [
            'id' => (int) $item->id,
            'seller_id' => (int) $item->seller_id,
            'buyer_id' => (int) $item->buyer_id,
            'item_id' => (int) $item->item_id,
            
            'item' => $itemObject,
            'seller' => $sellerObject,
            'buyer' => $buyerObject,
            
            'seller_visibility' => (string) $item->seller_visibility,
            'buyer_visibility' => (string) $item->buyer_visibility,
            'chat_url' => (string) $item->chat_url,
            
            'created_at' => (string) $item->created_at,
            'updated_at' => (string) $item->updated_at,
        ];
    }
}            
