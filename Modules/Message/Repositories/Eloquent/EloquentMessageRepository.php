<?php

namespace Modules\Message\Repositories\Eloquent;

use Modules\Message\Repositories\MessageRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Message\Entities\Message;

class EloquentMessageRepository extends EloquentBaseRepository implements MessageRepository
{

    public function getMessageListing($input, $perPage, $currentUserId) {
        $query = $this->model       
                ->orderBy('created_at', 'desc');
        
        $query = $query->where(function($q) use ($currentUserId){
            $q->where(function($qr) use ($currentUserId){
                $qr->where('seller_id', $currentUserId);    
                $qr->where('seller_visibility', Message::VISIBILITY_VISIBLE);
            });
            
            $q->orWhere(function($qr) use ($currentUserId){
                $qr->where('buyer_id', $currentUserId);    
                $qr->where('buyer_visibility', Message::VISIBILITY_VISIBLE);
            });
        });

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
