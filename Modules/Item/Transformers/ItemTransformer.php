<?php

namespace Modules\Item\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Item\Entities\Item;
use App\Common\Helper;
use Modules\Promote\Transformers\PromoteTransformer;

class ItemTransformer extends TransformerAbstract implements ItemTransformerInterface {

    /**
     * Turn this item object into a generic array.
     *
     * @param $item
     * @return array
     */
    public function transform(Item $item) {
        $isInFavorite = false;
        $currentLoggedUser = app('logged_user');

        $offerObjectStatus = null;
        $offerObjectId = null;
        $offerPriceNumber = null;
        $messageObject = null;
        
        if ($currentLoggedUser) {
            $isInFavorite = $item->favorite_user->contains($currentLoggedUser->appuser_id);                                  
        }
        
        if (isset($item->message_object)) {
            $messageObject = $item->message_object;
            
            $offerObject = $item->offer->where('buyer_id', $messageObject->buyer_id)
                    ->where('seller_id', $messageObject->seller_id)->first();
            if ($offerObject) {
                $offerObjectStatus = $offerObject->status;
                $offerObjectId = $offerObject->id;
                $offerPriceNumber = $offerObject->offer_number;
            }
        }
        
        $country = $item->country;
        $city = $item->city;
        $appuser = $item->appuser;
        $gallery = $item->gallery;
        $acceptedOffer = $item->accepted_offer;
        
        $promoteTransformer = new PromoteTransformer();
        $promoteObject = $item->promote;
        
        if ($promoteObject) {
            $promoteObject = $promoteTransformer->transform($promoteObject);
        }
        
        $itemStatusText = 'Selling';
        $itemSellStatus = 'selling';
        
        if ($item->sell_status == 'sold') {
            $itemStatusText = 'Sold';
            $itemSellStatus = 'sold';
        }
        
        if ($acceptedOffer) {
            if ($currentLoggedUser) {
                if ($currentLoggedUser->appuser_id == $acceptedOffer->buyer_id) {
                    $itemStatusText = 'Purchased';
                    $itemSellStatus = 'purchased';
                } else if ($currentLoggedUser->appuser_id == $acceptedOffer->seller_id) {
                    $itemSellStatus = 'sold';
                    if (!empty($item->discount_percent)) {
                        $itemStatusText = 'Sold at ' . $item->discount_percent . '% off';    
                    } else {
                        $itemStatusText = 'Sold';    
                    }
                }
            }            
        }    
        
        return [
            'id' => (int) $item->id,
            'appuser_id' => (int) $item->appuser_id,
            'appuser' => $appuser,
            'title' => (string) $item->title,                
            'description' => (string) $item->description,                    
            
            'country_id' => (int) $item->country_id,
            'country' => $country,
            
            'city_id' => (int) $item->city_id,            
            'city' => $city,
            
            'category_id' => (int) $item->category_id,
            'category' => $item->category,
            
            'subcategory_id' => (int) $item->subcategory_id,
            'subcategory' => $item->subcategory,
            'is_in_favorite' => (boolean) $isInFavorite,
            
            'item_condition' => (string) $item->item_condition,
            'price_currency' => (string) $item->price_currency,
            'deliver' => (string) $item->deliver,
            'price_number' => (float) $item->price_number,
            'discount_price_number' => (float) $item->discount_price_number,
            'discount_percent' => (float) $item->discount_percent,
            'meetup_location' => (string) $item->meetup_location,
            'latitude' => (string) $item->latitude,
            'longitude' => (string) $item->longitude, 
            'gallery' => $gallery,
            'sell_status' => (string) $item->sell_status,
            
            // using to show offer, accept, decline button
            'offer_object_status' => (string) $offerObjectStatus,
            
            // using to change offer status
            'offer_object_id' => $offerObjectId,
            
            'offer_price_number' => (float) $offerPriceNumber,
            
            // using to check for need create new group chat or not
            'message' => $messageObject,
            
            'featured' => (boolean) $item->featured,
            'promote_method' => (string) $item->promote_method, 
            'promote' => $promoteObject,
            'promote_package' => (int) $item->promote_package,
            'accepted_offer' => $acceptedOffer,
            
            'display_status_text' => (string) $itemStatusText,
            'display_sell_status' => (string) $itemSellStatus,
            
            'featured_start_date' => (string) $item->featured_start_date,
            'featured_end_date' => (string) $item->featured_end_date,
            
            'created_at' => (string) $item->created_at,
            'updated_at' => (string) $item->updated_at,
        ];
    }
}                           