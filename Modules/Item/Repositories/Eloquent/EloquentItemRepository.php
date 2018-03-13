<?php

namespace Modules\Item\Repositories\Eloquent;

use Modules\Item\Repositories\ItemRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Subcategory\Entities\Subcategory;
use Modules\Offer\Entities\Offer;
use Excel;
use Illuminate\Database\Eloquent\Collection;


class EloquentItemRepository extends EloquentBaseRepository implements ItemRepository
{
    public function getItemExportBackend($input) {
        $query = $this->model;                
                
        if (isset($input['title']) && !empty($input['title'])) {
            $query = $query->where('title', 'LIKE', '%' . $input['title'] . '%');
        }
        
        if (isset($input['category_id']) && !empty($input['category_id'])) {
            $query = $query->where('category_id', $input['category_id']);
        }
        
        if (isset($input['subcategory_id']) && !empty($input['subcategory_id'])) {
            $query = $query->where('subcategory_id', $input['subcategory_id']);
        }
        
        if (isset($input['featured']) && ($input['featured'] != "")) {
            $query = $query->where('featured', (int)$input['featured']);
        }
        
        if (isset($input['username']) && !empty($input['username'])) {
            $usernameInput = $input['username'];
            $query = $query->whereHas('appuser', function($qr) use ($usernameInput) {
                $qr->where('username', 'LIKE', '%' . $usernameInput . '%');
            });
        }
        
        if (isset($input['sell_status']) && !empty($input['sell_status'])) {
            $query = $query->where('sell_status', $input['sell_status']);
        }
        
        if (isset($input['created_at_from']) && !empty($input['created_at_from'])) {
            $dateFrom = \DateTime::createFromFormat('d/m/Y', $input['created_at_from']);
            $dateFromFormatted = $dateFrom->format('Y-m-d 00:00:00');
            $query = $query->where('created_at', '>=', $dateFromFormatted);
        }
        
        if (isset($input['created_at_to']) && !empty($input['created_at_to'])) {
            $dateTo = \DateTime::createFromFormat('d/m/Y', $input['created_at_to']);
            $dateToFormatted = $dateTo->format('Y-m-d 00:00:00');
            $query = $query->where('created_at', '<=', $dateToFormatted);
        }

                
        return $query->get();
    }
    
    public function itemExportExcel(Collection $itemCollection) {
        
        $exportedFile = Excel::create(trans('item::items.title.item export file name'), function($excel) use($itemCollection) {
            $excel->sheet(trans('item::items.title.item export sheet name'), function($sheet) use($itemCollection) {
                $sheet->loadView('item::admin.items.export', array('items' => $itemCollection));
            });
        })->export('xls');
        
        return $exportedFile;
    }
    
    public function getHomeItemFeaturedList($input, $appuserLogin) {
        $query = $this->model  
                ->with([
                    'country', 
                    'city', 
                    'appuser', 
                    'gallery', 
                    'accepted_offer', 
                    'favorite_user', 
                    'offer', 
                    'promote',
                    'category',
                    'subcategory'])
                ->where('featured', 1)
                ->limit(6);
        
//        $userHasPersonalization = false;
//        
//        if (!empty($appuserLogin)) {
//            $appuserObject = $appuserLogin->appuser;
//            if (!empty($appuserObject)) {
//                $userPersonalization = $appuserObject->personalization_subcategory;    
//                if (count($userPersonalization) > 0) {
//                    $userHasPersonalization = true;
//                }
//            }
//        }
//        
//        if ($userHasPersonalization) {
//            // Then query by user personalization
//            $arrPersonalize = $userPersonalization->pluck('id')->toArray();            
//            $arrPersonalizeRest = Subcategory::whereNotIn('id', $arrPersonalize)->pluck('id')->toArray();
//            
//            $arrAllSub = array_merge($arrPersonalize, $arrPersonalizeRest);            
//            $strAllSub = implode(', ', $arrAllSub);            
//            
//            $query = $query->orderByRaw("FIELD(subcategory_id, $strAllSub)");
//        } else {
//            // Randomly displayed item
//            $query = $query->inRandomOrder();
//        }
        
        // Randomly displayed item
        $query = $query->inRandomOrder();
            
        return $query->get();
    }
    
    public function getFavoriteItemFeaturedList($input, $appuserLogin) {
        $query = $this->model
                ->where('featured', 1)
                ->limit(6);
        
          
        $currentUserId = null;
        if (!empty($appuserLogin)) {
            $currentUserId = $appuserLogin->appuser_id;
        } 
        
        if ($currentUserId) {
            $query = $query->whereHas('favorite_user', function ($query) use ($currentUserId) {
                $query->where('appuser_id', '=', $currentUserId);
            });
        }
        
//        $userHasPersonalization = false;
//        
//        if (!empty($appuserLogin)) {
//            $appuserObject = $appuserLogin->appuser;
//            if (!empty($appuserObject)) {
//                $userPersonalization = $appuserObject->personalization_subcategory;    
//                if (count($userPersonalization) > 0) {
//                    $userHasPersonalization = true;
//                }
//            }
//        }
//        
//        if ($userHasPersonalization) {
//            // Then query by user personalization
//            $arrPersonalize = $userPersonalization->pluck('id')->toArray();            
//            $arrPersonalizeRest = Subcategory::whereNotIn('id', $arrPersonalize)->pluck('id')->toArray();
//            
//            $arrAllSub = array_merge($arrPersonalize, $arrPersonalizeRest);            
//            $strAllSub = implode(', ', $arrAllSub);            
//            
//            $query = $query->orderByRaw("FIELD(subcategory_id, $strAllSub)");
//        } else {
//            // Randomly displayed item
//            $query = $query->inRandomOrder();
//        }

        // Randomly displayed item
        $query = $query->inRandomOrder();
            
        return $query->get();
    }
    
    public function getHomeItemList($input, $perPage, $appuserLogin, $miminumDiscountSetting) {
        
        $query = $this->model->with([
            'country', 
            'city', 
            'appuser', 
            'gallery', 
            'accepted_offer', 
            'favorite_user', 
            'offer', 
            'promote',
            'category',
            'subcategory']);
        
        if (isset($input['excluded_ids']) && !empty($input['excluded_ids'])) {
            $arrayExcludedId = explode(',', $input['excluded_ids']);
            if ($arrayExcludedId > 0) {
                $query = $query->whereNotIn('id', $arrayExcludedId);
            }
        }                                
        
        $userHasPersonalization = false;
        
        if (!empty($appuserLogin)) {
            $appuserObject = $appuserLogin->appuser;
            if (!empty($appuserObject)) {
                $userPersonalization = $appuserObject->personalization_subcategory;    
                if (count($userPersonalization) > 0) {
                    $userHasPersonalization = true;
                }
            }
        }
        
        if ($userHasPersonalization) {
            // Then query by user personalization
            $arrPersonalize = $userPersonalization->pluck('id')->toArray();            
            $arrPersonalizeRest = Subcategory::whereNotIn('id', $arrPersonalize)->pluck('id')->toArray();
            
            $arrAllSub = array_merge($arrPersonalize, $arrPersonalizeRest);            
            $strAllSub = implode(', ', $arrAllSub);                                    
        } 

        if (isset($input['search']) && $input['search'] != "") {
            $search = $input['search'];
            $query = $query->where(function($q) use ($search){
                $q->where('title', 'LIKE', '%' . $search . '%');
                $q->orWhere('description', 'LIKE', '%' . $search . '%');
            });
            $query = $query->orderBy('featured', 'desc');
            if ($userHasPersonalization) {
                $query = $query->orderByRaw("FIELD(subcategory_id, $strAllSub)");
            }
        } else {
            if ($userHasPersonalization) {
                $query = $query->orderByRaw("FIELD(subcategory_id, $strAllSub)");
            } else {
                $query = $query->inRandomOrder();
            }
            $query = $query->where('featured', '!=', 1);
            
            // Item with discount < $miminumDiscountSetting % will not be shown on homepage,
            $query = $query->where(function($qr) use ($miminumDiscountSetting) {
                $qr->where(function($q) {                
                    $q->where(function($sq) {
                        $sq->whereNull('discount_percent');
                        $sq->orWhere('discount_percent', '=', 0);
                    });
                });
                $qr->orWhere(function($q) use ($miminumDiscountSetting) {
                    $q->where('discount_percent', '>=', $miminumDiscountSetting);
                });

            });
        }

        return $query->paginate($perPage);
    }
    
    public function getFilteredItemList($input, $perPage) {
        
        $query = $this->model->with([
            'country', 
            'city', 
            'appuser', 
            'gallery', 
            'accepted_offer', 
            'favorite_user', 
            'offer', 
            'promote',
            'category',
            'subcategory']);
        
        if (isset($input['excluded_ids']) && !empty($input['excluded_ids'])) {
            $arrayExcludedId = explode(',', $input['excluded_ids']);
            if ($arrayExcludedId > 0) {
                $query = $query->whereNotIn('id', $arrayExcludedId);
            }
        }   
        
        if (isset($input['country_id'])) {
            $query = $query->where('country_id', $input['country_id']);         
        } 
        
        if (isset($input['city_id'])) {
            $query = $query->where('city_id', $input['city_id']);         
        } 
        
        if (isset($input['category_id'])) {
            $query = $query->where('category_id', $input['category_id']);         
        } 

        if (isset($input['subcategory_id'])) {
            $query = $query->where('subcategory_id', $input['subcategory_id']);         
        }
        
        if (isset($input['search'])) {
            $search = $input['search'];
            $query = $query->where(function($q) use ($search){
                $q->where('title', 'LIKE', '%' . $search . '%');
                $q->orWhere('description', 'LIKE', '%' . $search . '%');
            });            
        }  
        
        if (isset($input['sort'])) {
            if ($input['sort'] == 'date') {
                $query = $query->orderBy('created_at', 'desc');
            } else if ($input['sort'] == 'featured') {
                $query = $query->orderBy('featured', 'desc');
            } else if ($input['sort'] == 'discount') {
                $query = $query->orderBy('discount_percent', 'desc');
            } else if ($input['sort'] == 'low_to_high_price') {
                $query = $query->orderBy('discount_price_number', 'asc');
            } else if ($input['sort'] == 'high_to_low_price') {
                $query = $query->orderBy('discount_price_number', 'desc');
            }
        }
        

        return $query->paginate($perPage);
    }
    
    public function getMyHistoryItemList($input, $perPage, $appuserLogin) {
        $query = $this->model->with([
            'country', 
            'city', 
            'appuser', 
            'gallery', 
            'accepted_offer', 
            'favorite_user', 
            'offer', 
            'promote',
            'category',
            'subcategory']);        
          
        $currentUserId = null;
        if (!empty($appuserLogin)) {
            $currentUserId = $appuserLogin->appuser_id;
        } 
        
        $query = $query->where(function($qr) use ($currentUserId) {
            $qr->where(function($qry) use ($currentUserId) {
                $qry->where('appuser_id', '=', $currentUserId);                
            });
            
            $qr->orWhere(function($qry) use ($currentUserId) {
                $qry->where('appuser_id', '!=', $currentUserId);
                $qry->whereHas('offer', function ($q) use ($currentUserId) {
                    $q->where('buyer_id', '=', $currentUserId);
                    $q->where('status', '=', Offer::STATUS_ACCEPTED);
                });
            });            
            
        });
        
        if (isset($input['search'])) {
            $search = $input['search'];
            $query = $query->where(function($q) use ($search){
                $q->where('title', 'LIKE', '%' . $search . '%');
                $q->orWhere('description', 'LIKE', '%' . $search . '%');
            });            
        }
        
        $query = $query->orderBy('created_at', 'desc');

        return $query->paginate($perPage);
    }
    
    public function getFavoriteItemList ($input, $perPage, $appuserLogin) {        
        
        $query = $this->model->with([
            'country', 
            'city', 
            'appuser', 
            'gallery', 
            'accepted_offer', 
            'favorite_user', 
            'offer', 
            'promote',
            'category',
            'subcategory']);
        
        $userHasPersonalization = false;
        
        if (!empty($appuserLogin)) {
            $appuserObject = $appuserLogin->appuser;
            if (!empty($appuserObject)) {
                $userPersonalization = $appuserObject->personalization_subcategory;    
                if (count($userPersonalization) > 0) {
                    $userHasPersonalization = true;
                }
            }
        }
        
        if ($userHasPersonalization) {
            // Then query by user personalization
            $arrPersonalize = $userPersonalization->pluck('id')->toArray();            
            $arrPersonalizeRest = Subcategory::whereNotIn('id', $arrPersonalize)->pluck('id')->toArray();
            
            $arrAllSub = array_merge($arrPersonalize, $arrPersonalizeRest);            
            $strAllSub = implode(', ', $arrAllSub);            
            
            $query = $query->orderByRaw("FIELD(subcategory_id, $strAllSub)");
        } else {
            // Randomly displayed item
            $query = $query->inRandomOrder();
        }                
        
        if (isset($input['excluded_ids']) && !empty($input['excluded_ids'])) {
            $arrayExcludedId = explode(',', $input['excluded_ids']);
            if ($arrayExcludedId > 0) {
                $query = $query->whereNotIn('id', $arrayExcludedId);
            }
        }
        
        $appuserId = $appuserLogin->appuser_id;     
        
        if ($appuserId) {
            $query = $query->whereHas('favorite_user', function ($query) use ($appuserId) {
                $query->where('appuser_id', '=', $appuserId);
            });
        }

        if (isset($input['search']) && $input['search'] != "") {
            $search = $input['search'];
            $query = $query->where(function($q) use ($search){
                $q->where('title', 'LIKE', '%' . $search . '%');
                $q->orWhere('description', 'LIKE', '%' . $search . '%');
            });
        } else {
            $query = $query->where('featured', '!=', 1);
        }

        return $query->paginate($perPage);
    }
    
    
    
    public function getSearchItemAutocomplete($input, $appuserId) {
        $query = $this->model       
                ->select('title', 'description', 'id')
                ->orderBy('title', 'asc');
        
        if (isset($input['search'])) {
            $search = $input['search'];
            $query = $query->where(function($q) use ($search){
                $q->where('title', 'LIKE', $search . '%');
                $q->orWhere('description', 'LIKE', $search . '%');
            });
        }
        
        return $query->get();

    }
    
    public function getFilterItemsAutocomplete($input) {
        $query = $this->model                
                ->select('title', 'description', 'id')
                ->orderBy('title', 'asc');
        
        if (isset($input['excluded_ids']) && !empty($input['excluded_ids'])) {
            $arrayExcludedId = explode(',', $input['excluded_ids']);
            if ($arrayExcludedId > 0) {
                $query = $query->whereNotIn('id', $arrayExcludedId);
            }
        }   
        
        if (isset($input['country_id'])) {
            $query = $query->where('country_id', $input['country_id']);         
        } 
        
        if (isset($input['city_id'])) {
            $query = $query->where('city_id', $input['city_id']);         
        } 
        
        if (isset($input['category_id'])) {
            $query = $query->where('category_id', $input['category_id']);         
        } 

        if (isset($input['subcategory_id'])) {
            $query = $query->where('subcategory_id', $input['subcategory_id']);         
        }                
        
        if (isset($input['search'])) {
            $search = $input['search'];
            $query = $query->where(function($q) use ($search){
                $q->where('title', 'LIKE', $search . '%');
                $q->orWhere('description', 'LIKE', $search . '%');
            });
        }
        
        return $query->get();
    }
    
    
    public function getSearchItemAutocompleteFavorite($input, $appuserId) {
        $query = $this->model                
                ->select('title', 'description', 'id')
                ->orderBy('title', 'asc');
        
        if ($appuserId) {
            $query = $query->whereHas('favorite_user', function ($query) use ($appuserId) {
                $query->where('appuser_id', '=', $appuserId);
            });
        }
        
        if (isset($input['search'])) {
            $search = $input['search'];
            $query = $query->where(function($q) use ($search){
                $q->where('title', 'LIKE', $search . '%');
                $q->orWhere('description', 'LIKE', $search . '%');
            });
        }
        
        return $query->get();
    }
}
