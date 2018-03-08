<?php

namespace Modules\Offer\Repositories\Eloquent;

use Modules\Offer\Repositories\OfferRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Offer\Entities\Offer;

class EloquentOfferRepository extends EloquentBaseRepository implements OfferRepository
{
    public function getOfferListing($input, $perPage, $currentUserId) {
        $query = $this->model       
                ->orderBy('created_at', 'desc');                

        if (isset($input['search'])) {
            $search = $input['search'];
            $query = $query->where(function($q) use ($search){
                $q->whereHas('item', function ($qr) use ($search) {
                    $qr->where('title', 'LIKE', '%' . $search . '%');
                }); 
                
                $q->orWhereHas('buyer', function ($qr) use ($search) {
                    $qr->where('username', 'LIKE', '%' . $search . '%');
                    $qr->orWhere('full_name', 'LIKE', '%' . $search . '%');
                }); 
                
                $q->orWhereHas('seller', function ($qr) use ($search) {
                    $qr->where('username', 'LIKE', '%' . $search . '%');
                    $qr->orWhere('full_name', 'LIKE', '%' . $search . '%');
                }); 
            });
            
        }
        
        return $query->paginate($perPage);
    }
}
