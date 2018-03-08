<?php

namespace Modules\Offer\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Offer\Entities\Offer;
use App\Common\Helper;


class OfferTransformer extends TransformerAbstract implements OfferTransformerInterface {

    /**
     * Turn this item object into a generic array.
     *
     * @param $item
     * @return array
     */
    public function transform(Offer $item) {
        $itemObject = $item->item; 
        $itemGallery = $item->item->gallery;

        $sellerObject = $item->seller;
        $avatarSeller = $sellerObject->avatar_image->first();
        $sellerObject->avatar = $avatarSeller;
                
        $buyerObject = $item->buyer;
        $avatarBuyer = $buyerObject->avatar_image->first();
        $buyerObject->avatar = $avatarBuyer;
        
        return [
            'id' => (int) $item->id,
            'seller_id' => (int) $item->seller_id,
            'buyer_id' => (int) $item->buyer_id,
            'item_id' => (int) $item->item_id,
            'status' => (string) $item->status,
            'offer_number' => (float) $item->offer_number,
            'item' => $itemObject,
            'seller' => $sellerObject,
            'buyer' => $buyerObject,
            
            'created_at' => (string) $item->created_at,
            'updated_at' => (string) $item->updated_at,
        ];
    }
}            
