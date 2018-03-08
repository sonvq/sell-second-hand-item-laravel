<?php

namespace Modules\Appuser\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Appuser\Entities\Appuser;
use App\Common\Helper;

class AppuserTransformer extends TransformerAbstract implements AppuserTransformerInterface {

    /**
     * Turn this item object into a generic array.
     *
     * @param $item
     * @return array
     */
    public function transform(Appuser $item) {
        
        $token = isset($item->token) ? $item->token : null;
        $country = $item->country;
        $city = $item->city;
        $personalization = $item->personalization_subcategory;
        $avatar = $item->avatar_image->first();
                
        
        return [
            'id' => (int) $item->id,
            'username' => (string) $item->username,
            'full_name' => (string) $item->full_name,                
            'email' => (string) $item->email,                    
            'phone_number' => (string) $item->phone_number,
            'gender' => (string) $item->gender,
            'date_of_birth' => (string) $item->date_of_birth,
            'country_id' => (int) $item->country_id,
            'city_id' => (int) $item->city_id,
            'country' => $country,
            'city' => $city,
            'push_notification' => (int) $item->push_notification,
            'first_time_login' => (int) $item->first_time_login,           
            'status' => (string) $item->status,
            'token' => (string) $token,       
            'avatar' => $avatar,
            'personalization' => $personalization,
            'created_at' => (string) $item->created_at,
            'updated_at' => (string) $item->updated_at,
        ];
    }
}                           


            
            