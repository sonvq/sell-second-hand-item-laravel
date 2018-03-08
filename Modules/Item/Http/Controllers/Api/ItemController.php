<?php

namespace Modules\Item\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use InvalidArgumentException;
use Modules\User\Entities\Sentinel\User;
use Dingo\Api\Routing\Helpers;
use Modules\Base\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Facades\Password;
use App\Common\Helper;
use Modules\Appuser\Repositories\AppuserRepository;
use Modules\Appuser\Repositories\AppuserLoginRepository;
use Modules\City\Entities\City;
use Modules\Appuser\Transformers\AppuserTransformerInterface;
use Modules\Country\Repositories\CountryRepository;
use Modules\Country\Entities\Country;
use Modules\Category\Entities\Category;
use Modules\Item\Repositories\ItemRepository;
use Modules\Subcategory\Entities\Subcategory;
use Modules\Item\Transformers\ItemTransformerInterface;
use Modules\Item\Entities\Item;
use Modules\Media\Entities\File;
use Modules\Item\Transformers\ItemSearchTransformerInterface;
use Modules\Item\Entities\ItemFavorite;
use Carbon\Carbon;
use Modules\Promote\Entities\Promote;
use Modules\Setting\Repositories\SettingRepository;
use Modules\Message\Entities\Message;
use Modules\Appuser\Entities\AppuserActivity;
use Log;
use Modules\Email\Entities\Email;
use Illuminate\Support\Facades\Mail;

class ItemController extends BaseController
{
    protected $module_name = 'item';
            
    public function __construct(Request $request, 
            AppuserRepository $appuserRepository,
            AppuserLoginRepository $appuserLoginRepository,
            CountryRepository $countryRepository,
            AppuserTransformerInterface $appuserTransformer,
            ItemRepository $itemRepository,
            ItemTransformerInterface $itemTransformer,
            ItemSearchTransformerInterface $itemSearchTransformer,
            SettingRepository $settingRepository)
    {
        
        $this->request = $request;
        $this->appuser_repository = $appuserRepository;
        $this->appuser_login_repository = $appuserLoginRepository;
        $this->appuser_transformer = $appuserTransformer;
        $this->country_repository = $countryRepository;
        $this->item_repository = $itemRepository;
        $this->item_transformer = $itemTransformer;
        $this->item_search_transformer = $itemSearchTransformer;
        $this->setting_repository = $settingRepository;
    }
    
    public function filterItems() {
        $input = $this->request->all();
        $perPage = (isset($input['per_page']) && $input['per_page'] > 0) ? $input['per_page'] : 15;
        if (isset($input['excluded_ids']) && !empty($input['excluded_ids'])) {
            $this->request->merge(['page' => 1]);            
        }
        
        $itemList = $this->item_repository->getFilteredItemList($input, $perPage);

        return $this->response->paginator($itemList, $this->item_transformer);
    }
    
     public function filterItemsAutocomplete() {
        $input = $this->request->all();        
        
        $itemList = $this->item_repository->getFilterItemsAutocomplete($input);

        return $this->response->collection($itemList, $this->item_search_transformer);
    }        
    
    public function myHistory() {
        $input = $this->request->all();
        $perPage = (isset($input['per_page']) && $input['per_page'] > 0) ? $input['per_page'] : 15;
        $currentLoggedUser = app('logged_user');                      
        
        $itemList = $this->item_repository
                    ->getMyHistoryItemList($input, $perPage, $currentLoggedUser);

        return $this->response->paginator($itemList, $this->item_transformer);
    }
    
    public function getItemByChatUrl() {
        $input =  $this->request->all();  
        
        // Validate create new item
        $validate = $this->validateRequest('api-get-item-by-chat-url', $input);
        if ($validate !== true) {
            return $validate;
        }
        
        $messageObject = Message::where('chat_url', $input['chat_url'])->with(['seller', 'seller.avatar_image', 'buyer', 'buyer.avatar_image'])->first();
        
        $messageObject->seller->avatar = $messageObject->seller->avatar_image->first();
        $messageObject->buyer->avatar = $messageObject->buyer->avatar_image->first();
        
        if (!$messageObject) {
            return Helper::notFoundErrorResponse(Helper::MESSAGE_NOT_FOUND,
                    Helper::MESSAGE_NOT_FOUND_TITLE,
                    Helper::MESSAGE_NOT_FOUND_MSG);
        }
        
        $itemObject = Item::where('id', $messageObject->item_id)->first();
        
        $itemObject->message_object = $messageObject;
        
        if (empty($itemObject)) {
            return Helper::notFoundErrorResponse(Helper::ITEM_NOT_FOUND,
                    Helper::ITEM_NOT_FOUND_TITLE,
                    Helper::ITEM_NOT_FOUND_MSG);
        }                          
        
        return $this->response->item($itemObject, $this->item_transformer);   
    }
    
    
    public function index() {
        $input = $this->request->all();
        $perPage = (isset($input['per_page']) && $input['per_page'] > 0) ? $input['per_page'] : 15;
        
        if (isset($input['excluded_ids']) && !empty($input['excluded_ids'])) {
            $this->request->merge(['page' => 1]);            
        }
        
        $currentLoggedUser = app('logged_user');       
        
        $miminumDiscountSetting = 30;
        $settings = $this->setting_repository->all();        
        
        // Promote method
        if (isset($settings['item::minimum-discount-for-promote'])) {
            $miminumDiscountObject = $settings['item::minimum-discount-for-promote'];  
            $miminumDiscountSetting = (int)$miminumDiscountObject['plainValue'];
        } 
        
        $itemList = $this->item_repository->getHomeItemList($input, $perPage, $currentLoggedUser, $miminumDiscountSetting);

        return $this->response->paginator($itemList, $this->item_transformer);
    }
    
    public function getFavoriteItemList() {
        $input = $this->request->all();
        $perPage = (isset($input['per_page']) && $input['per_page'] > 0) ? $input['per_page'] : 15;
        if (isset($input['excluded_ids']) && !empty($input['excluded_ids'])) {
            $this->request->merge(['page' => 1]);            
        }
        
        $currentLoggedUser = app('logged_user');          
        
        $itemList = $this->item_repository->getFavoriteItemList($input, $perPage, $currentLoggedUser);

        return $this->response->paginator($itemList, $this->item_transformer);
    }
        
    public function featuredItemsFavorite() {
        $input = $this->request->all();
        $currentLoggedUser = app('logged_user');     
        
        $itemList = $this->item_repository->getFavoriteItemFeaturedList($input, $currentLoggedUser);

        return $this->response->collection($itemList, $this->item_transformer);
    }
    
    public function markItemAsSold($id) {
        $currentLoggedUser = app('logged_user');       
        
        $item = $this->item_repository->find($id);
        
        if (!$item) {
            return Helper::unauthorizedErrorResponse(Helper::ITEM_NOT_FOUND,
                    Helper::ITEM_NOT_FOUND_TITLE,
                    Helper::ITEM_NOT_FOUND_MSG);
        }
        
        // Check if current logged in user is owner of this item
        if ($item->appuser_id != $currentLoggedUser->appuser_id) {
            return Helper::unauthorizedErrorResponse(Helper::OWNER_OF_ITEM_REQUIRED,
                    Helper::OWNER_OF_ITEM_REQUIRED_TITLE,
                    Helper::OWNER_OF_ITEM_REQUIRED_MSG);
        }
        
        $item->sell_status = Item::SELL_STATUS_SOLD;
               
        $item->save();
        
        // Log register activity
        $userActivity = new AppuserActivity();
        $userActivity->appuser_id = $currentLoggedUser->appuser_id;
        $userActivity->action = AppuserActivity::ACTION_MARK_SOLD_ITEM;
        $userActivity->item_id = $item->id;
        $userActivity->log_time = Carbon::now();
        $userActivity->save();

        return $this->response->item($item, $this->item_transformer);
    }
    
    public function submitPromotePackage($id) {
        $input = $this->request->all();
        $currentLoggedUser = app('logged_user');
        
        // Validate submit promote package
        $validate = $this->validateRequest('api-submit-promote-package', $input);
        if ($validate !== true) {
            return $validate;
        }
        
        $item = $this->item_repository->find($id);
        
        if (!$item) {
            return Helper::unauthorizedErrorResponse(Helper::ITEM_NOT_FOUND,
                    Helper::ITEM_NOT_FOUND_TITLE,
                    Helper::ITEM_NOT_FOUND_MSG);
        }
        
        // Check if current logged in user is owner of this item
        if ($item->appuser_id != $currentLoggedUser->appuser_id) {
            return Helper::unauthorizedErrorResponse(Helper::OWNER_OF_ITEM_REQUIRED,
                    Helper::OWNER_OF_ITEM_REQUIRED_TITLE,
                    Helper::OWNER_OF_ITEM_REQUIRED_MSG);
        }
        
        $item->promote_method = $input['promote_method'];
        if (isset($input['promote_package']) && !empty($input['promote_package'])) {
            $item->promote_package = $input['promote_package'];    
        }
        $item->featured = 1;
        
        // Caculate featured start date and end date
        $today = Carbon::now();
        $expired_date = Carbon::now();        
        
        if ($input['promote_method'] == 'social_promote') {
            // Default facebook promote period is 7 days if admin has not set in backend yet
            $defaultFacebookPromotePeriod = 7;
            $settings = $this->setting_repository->all();        
            if (isset($settings['item::default-facebook-promote-days'])) {
                $defaultFacebookObject = $settings['item::default-facebook-promote-days'];
                $defaultFacebookPromotePeriod = (int)$defaultFacebookObject['plainValue'];
            }
            $expired_date = $today->copy()->addDays($defaultFacebookPromotePeriod);
            $item->promote_package = null;
        } elseif ($input['promote_method'] == 'listing_promote') {
            // Get promote package
            $promoteObject = Promote::where('id', $input['promote_package'])->first();            
            $expired_date = $today->copy()->addDays($promoteObject->number_of_date_expired);
            
            // Send email promote for item
            $promoteEmail = Email::where('type', Email::TYPE_PROMOTE_EMAIL)->where('status', Email::STATUS_PUBLISH)->first();
            $itemOwner = $item->appuser;
            if ($promoteEmail && $itemOwner) {

                $content = $promoteEmail->content;
                $search = [
                    '[full_name]', 
                    '[promote_days]', 
                    '[username]',
                    '[item_title]',
                    '[featured_start_date]',
                    '[featured_end_date]',
                    '[phone_number]',
                    '[city]',
                    '[country]',
                    '[qty_no]',
                    '[package_name]',
                    '[unit_price]',
                    '[amount]',
                    '[receipt_no]',
                    '[receipt_date]'
                ];
//                $replaceWith = [$itemOwner->full_name, $itemObject->title, $itemObject->price_currency, $input['offer_number'], $currentLoggedUser->appuser->full_name];      
                
                $replaceWith = [
                    $itemOwner->full_name, 
                    $promoteObject->number_of_date_expired, 
                    $currentLoggedUser->appuser->full_name,
                    $item->title,
                    $today->copy()->setTimezone('Asia/Yangon')->format('jS F Y h:i A') . ' ' . $currentLoggedUser->appuser->city->name . ', ' . $currentLoggedUser->appuser->country->name,
                    $expired_date->copy()->setTimezone('Asia/Yangon')->format('jS F Y h:i A') . ' ' . $currentLoggedUser->appuser->city->name . ', ' . $currentLoggedUser->appuser->country->name,
                    $currentLoggedUser->appuser->phone_number,
                    $currentLoggedUser->appuser->city->name,
                    $currentLoggedUser->appuser->country->name,
                    1,
                    "$promoteObject->number_of_date_expired Days Promotion at $promoteObject->price_amount MMK",
                    "$promoteObject->price_amount MMK",
                    "$promoteObject->price_amount MMK",
                    "NA",
                    "NA",
                    
                ];
                $newContent = str_replace($search, $replaceWith, $content);            

                $subject = $promoteEmail->subject;
                $subject = str_replace('[item_title]', $item->title, $subject);
                               
                Mail::send('appuser::frontend.mail.mail_template', ['content' => $newContent], function ($m) use ($input, $subject, $itemOwner) {
                    $m->to($itemOwner->email)->subject($subject);
                });
                if (Mail::failures()) {
                    return Helper::internalServerErrorResponse(Helper::FAIL_TO_SEND_EMAIL,
                                Helper::FAIL_TO_SEND_EMAIL_TITLE,
                                Helper::FAIL_TO_SEND_EMAIL_MSG);
                } 
            }
        }
        
        $item->featured_start_date = $today;
        $item->featured_end_date = $expired_date;
        
        $item->save();
        
        // Log register activity
        $userActivity = new AppuserActivity();
        $userActivity->appuser_id = $currentLoggedUser->appuser_id;
        $userActivity->action = AppuserActivity::ACTION_PROMOTE_ITEM;
        $userActivity->item_id = $item->id;
        $userActivity->log_time = Carbon::now();
        $userActivity->save();

        return $this->response->item($item, $this->item_transformer);
    }
    
    public function featuredItems() {
        $input = $this->request->all();
        $currentLoggedUser = app('logged_user');
                       
        $itemList = $this->item_repository->getHomeItemFeaturedList($input, $currentLoggedUser);

        return $this->response->collection($itemList, $this->item_transformer);
    }
    
    public function searchAutocomplete() {
        $input = $this->request->all();
        $currentLoggedUser = app('logged_user');
        
        $currentUserId = null;
        if (!empty($currentLoggedUser)) {
            $currentUserId = $currentLoggedUser->appuser_id;
        } 
        
        $itemList = $this->item_repository->getSearchItemAutocomplete($input, $currentUserId);

        return $this->response->collection($itemList, $this->item_search_transformer);
    }
    
    public function searchAutocompleteFavorite() {
        $input = $this->request->all();
        $currentLoggedUser = app('logged_user');
        
        $currentUserId = null;
        if (!empty($currentLoggedUser)) {
            $currentUserId = $currentLoggedUser->appuser_id;
        } 
        
        $itemList = $this->item_repository->getSearchItemAutocompleteFavorite($input, $currentUserId);

        return $this->response->collection($itemList, $this->item_search_transformer);
    }
    
    public function show($id) {
        $item = Item::where('id', $id)->first();        
        
        if (!$item) {
            return Helper::unauthorizedErrorResponse(Helper::ITEM_NOT_FOUND,
                    Helper::ITEM_NOT_FOUND_TITLE,
                    Helper::ITEM_NOT_FOUND_MSG);
        }                
        
        $currentLoggedUser = app('logged_user');
        
        $messageObject = null;
        $currentUserId = null;
        if (!empty($currentLoggedUser)) {
            $currentUserId = $currentLoggedUser->appuser_id;
            $messageObject = Message::where('buyer_id', $currentUserId)
                    ->where('item_id', $item->id)
                    ->where('seller_id', $item->appuser_id)
                    ->with(['seller', 'buyer'])->first();
        }                       
        
        $item->message_object = $messageObject;
                

        return $this->response->item($item, $this->item_transformer);
    }
    
    public function toggleFavorite($id) {
        $item = $this->item_repository->find($id);
        $currentLoggedUser = app('logged_user');
        
        if (!$item) {
            return Helper::unauthorizedErrorResponse(Helper::ITEM_NOT_FOUND,
                    Helper::ITEM_NOT_FOUND_TITLE,
                    Helper::ITEM_NOT_FOUND_MSG);
        }
        
        // Find existing favorite record
        $existingFavoriteRecord = ItemFavorite::where('appuser_id', $currentLoggedUser->appuser_id)
                ->where('item_id', $id)->get();
        
        if (count($existingFavoriteRecord) > 0) {
            $existingFavoriteRecord = ItemFavorite::where('appuser_id', $currentLoggedUser->appuser_id)
                ->where('item_id', $id)->delete();
        } else {
            $createdItemFavorite = new ItemFavorite();
            $createdItemFavorite->appuser_id = $currentLoggedUser->appuser_id;
            $createdItemFavorite->item_id = $id;
            
            $createdItemFavorite->save();
        }

        return $this->response->item($item, $this->item_transformer);
    }
    
    public function update($id) {
        $item = $this->item_repository->find($id);
        $currentLoggedUser = app('logged_user');
        $input =  $this->request->all();                     
        
        if (!$item) {
            return Helper::unauthorizedErrorResponse(Helper::ITEM_NOT_FOUND,
                    Helper::ITEM_NOT_FOUND_TITLE,
                    Helper::ITEM_NOT_FOUND_MSG);
        }
        
        // Check if current logged in user is owner of this item
        if ($item->appuser_id != $currentLoggedUser->appuser_id) {
            return Helper::unauthorizedErrorResponse(Helper::OWNER_OF_ITEM_REQUIRED,
                    Helper::OWNER_OF_ITEM_REQUIRED_TITLE,
                    Helper::OWNER_OF_ITEM_REQUIRED_MSG);
        }
        
        // Does not allow to update item if sell_status = sold
        if ($item->sell_status == Item::SELL_STATUS_SOLD) {
            return Helper::badRequestErrorResponse(Helper::ITEM_SOLD_CAN_NOT_UPDATE,
                            Helper::ITEM_SOLD_CAN_NOT_UPDATE_TITLE,
                            Helper::ITEM_SOLD_CAN_NOT_UPDATE_MSG);
        }
        
        
        // Validate update item
        $validate = $this->validateRequest('api-check-item-update', $input);
        if ($validate !== true) {
            return $validate;
        }        

        if (isset($input['city_id']) && !empty($input['city_id']) && isset($input['country_id']) && !empty($input['country_id'])){
            $cityObject = City::find($input['city_id']);
            if ($cityObject) {
                if($cityObject->country_id != $input['country_id']){
                    return Helper::badRequestErrorResponse(Helper::COUNTRY_AND_CITY_NOT_MATCH,
                            Helper::COUNTRY_AND_CITY_NOT_MATCH_TITLE,
                            Helper::COUNTRY_AND_CITY_NOT_MATCH_MSG);
                }
            }
        }
        
        if (isset($input['category_id']) && !empty($input['category_id']) && isset($input['subcategory_id']) && !empty($input['subcategory_id'])){
            $subcategoryObject = Subcategory::find($input['subcategory_id']);
            if ($subcategoryObject) {
                if($subcategoryObject->category_id != $input['category_id']){
                    return Helper::badRequestErrorResponse(Helper::CATEGORY_AND_SUBCATEGORY_NOT_MATCH,
                            Helper::CATEGORY_AND_SUBCATEGORY_NOT_MATCH_TITLE,
                            Helper::CATEGORY_AND_SUBCATEGORY_NOT_MATCH_MSG);
                }
            }
        }                
        
        $actionType = AppuserActivity::ACTION_EDIT_ITEM;
        
        if (isset($input['discount_percent']) && ($item->discount_percent != $input['discount_percent'])) {
            $actionType = AppuserActivity::ACTION_DISCOUNTED_ITEM;    
        } 
        
        if (isset($input['discount_percent']) && isset($input['price_number'])) {
            $input['discount_price_number'] = $input['price_number'] - ($input['price_number']*$input['discount_percent'])/100;
        }
        
        // Successfull validated data, start to update item       
        $updatedItem = $this->item_repository->update($item, $input);
        
        // Save gallery for item
        if (isset($input['gallery']) && !empty($input['gallery'])) {
            $listId = explode(',', $input['gallery']);
            $countFile = File::whereIn('id', $listId)->count();
            if ($countFile != count($listId)) {
                return Helper::badRequestErrorResponse(Helper::FILE_DOES_NOT_EXIST_OR_DELETED,
                            Helper::FILE_DOES_NOT_EXIST_OR_DELETED_TITLE,
                            Helper::FILE_DOES_NOT_EXIST_OR_DELETED_MSG);
            }
            if (count($listId) > 0) {
                $arrayToSync = [];
                foreach ($listId as $singleId) {                    
                    $arrayToSync[$singleId] = ['imageable_type' => Item::class, 'zone' => Item::ZONE_ITEM_GALLERY_IMAGE];
                }
                $updatedItem->files()->sync($arrayToSync);
            }
        } else {
            $updatedItem->files()->detach();
        }
        
        $returnedItem = $this->item_repository->find($updatedItem->id);                
        
        // Log register activity
        $userActivity = new AppuserActivity();
        $userActivity->appuser_id = $currentLoggedUser->appuser_id;
        $userActivity->action = $actionType;
        $userActivity->item_id = $returnedItem->id;
        $userActivity->log_time = Carbon::now();
        $userActivity->save();
     
        return $this->response->item($returnedItem, $this->item_transformer); 
    }
    
    public function store() {
        $input =  $this->request->all();                     
        
        // Validate create new item
        $validate = $this->validateRequest('api-check-item-create', $input);
        if ($validate !== true) {
            return $validate;
        }
        
        $currentLoggedUser = app('logged_user');        

        if (isset($input['city_id']) && !empty($input['city_id']) && isset($input['country_id']) && !empty($input['country_id'])){
            $cityObject = City::find($input['city_id']);
            if ($cityObject) {
                if($cityObject->country_id != $input['country_id']){
                    return Helper::badRequestErrorResponse(Helper::COUNTRY_AND_CITY_NOT_MATCH,
                            Helper::COUNTRY_AND_CITY_NOT_MATCH_TITLE,
                            Helper::COUNTRY_AND_CITY_NOT_MATCH_MSG);
                }
            }
        }
        
        if (isset($input['category_id']) && !empty($input['category_id']) && isset($input['subcategory_id']) && !empty($input['subcategory_id'])){
            $subcategoryObject = Subcategory::find($input['subcategory_id']);
            if ($subcategoryObject) {
                if($subcategoryObject->category_id != $input['category_id']){
                    return Helper::badRequestErrorResponse(Helper::CATEGORY_AND_SUBCATEGORY_NOT_MATCH,
                            Helper::CATEGORY_AND_SUBCATEGORY_NOT_MATCH_TITLE,
                            Helper::CATEGORY_AND_SUBCATEGORY_NOT_MATCH_MSG);
                }
            }
        }
        
        
        // Successfull validated data, start to create new item
        $input['appuser_id'] = $currentLoggedUser->appuser_id;
        
        $input['discount_price_number'] = $input['price_number'];
        $input['discount_percent'] = 0;
        
        $createdItem = $this->item_repository->create($input);
        
        // Save gallery for item
        if (isset($input['gallery']) && !empty($input['gallery'])) {
            $listId = explode(',', $input['gallery']);
            $countFile = File::whereIn('id', $listId)->count();
            if ($countFile != count($listId)) {
                return Helper::badRequestErrorResponse(Helper::FILE_DOES_NOT_EXIST_OR_DELETED,
                            Helper::FILE_DOES_NOT_EXIST_OR_DELETED_TITLE,
                            Helper::FILE_DOES_NOT_EXIST_OR_DELETED_MSG);
            }
            if (count($listId) > 0) {
                foreach ($listId as $singleId) {
                    $createdItem->files()->attach($singleId, ['imageable_type' => Item::class, 'zone' => Item::ZONE_ITEM_GALLERY_IMAGE]);
                }
            }
        } 
        
        $returnedItem = $this->item_repository->find($createdItem->id);
        
        // Log register activity
        $userActivity = new AppuserActivity();
        $userActivity->appuser_id = $currentLoggedUser->appuser_id;
        $userActivity->action = AppuserActivity::ACTION_CREATE_ITEM;
        $userActivity->item_id = $createdItem->id;
        $userActivity->log_time = Carbon::now();
        $userActivity->save();
     
        return $this->response->item($returnedItem, $this->item_transformer); 
    }     
    
    public function updateExpiredPromoteItem() {
        // Update item promote from 1 to 0 if featured_end_date < now
        $itemListId = Item::where('featured', 1)->where('featured_end_date', '<=', date("Y-m-d H:i:s"))->pluck('id')->toArray();
        
        // Update
        Item::where('featured', 1)->where('featured_end_date', '<=', date("Y-m-d H:i:s"))->update(['featured' => 0]);
        
        // Save Log
        Log::info('Run cronjob - ItemController - updateExpiredPromoteItem, affected item id: ' . print_r($itemListId, true));
                
    }
}

