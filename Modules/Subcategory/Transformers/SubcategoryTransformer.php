<?php

namespace Modules\Subcategory\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Subcategory\Entities\Subcategory;
use App\Common\Helper;
use Modules\Promote\Transformers\PromoteTransformer;

class SubcategoryTransformer extends TransformerAbstract implements SubcategoryTransformerInterface {

    /**
     * Turn this item object into a generic array.
     *
     * @param $item
     * @return array
     */
    public function transform(Subcategory $item) {
        
        $currentLoggedUser = app('logged_user');

        $isInPersonalization = false;
        if ($currentLoggedUser) {
            $isInPersonalization = $item->subcategory_appuser->contains($currentLoggedUser->appuser_id);
        }
                
        
        return [
            'id' => (int) $item->id,
            'name' => (string) $item->name,
            'category_id' => (int) $item->category_id,
            'status' => (string) $item->status,                            
            'is_in_personalization' => (boolean) $isInPersonalization,
            
            'created_at' => (string) $item->created_at,
            'updated_at' => (string) $item->updated_at,
        ];
    }
}                           