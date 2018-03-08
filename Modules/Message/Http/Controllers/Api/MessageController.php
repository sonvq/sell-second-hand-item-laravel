<?php

namespace Modules\Message\Http\Controllers\Api;

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
use Modules\Message\Transformers\MessageTransformerInterface;
use Modules\Message\Repositories\MessageRepository;


class MessageController extends BaseController
{
    protected $module_name = 'message';
            
    public function __construct(Request $request, 
            AppuserRepository $appuserRepository,
            AppuserLoginRepository $appuserLoginRepository,
            CountryRepository $countryRepository,
            AppuserTransformerInterface $appuserTransformer,
            ItemRepository $itemRepository,
            ItemTransformerInterface $itemTransformer,
            ItemSearchTransformerInterface $itemSearchTransformer,
            SettingRepository $settingRepository,
            MessageTransformerInterface $messageTransformer,
            MessageRepository $messageRepository)
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
        $this->message_transformer = $messageTransformer;
        $this->message_repository = $messageRepository;
        
    }
    
    public function index() {
        $input = $this->request->all();
        $perPage = (isset($input['per_page']) && $input['per_page'] > 0) ? $input['per_page'] : 15;
        $currentLoggedUser = app('logged_user');
        
        $currentUserId = $currentLoggedUser->appuser_id;                
        
        $messageList = $this->message_repository->getMessageListing($input, $perPage, $currentUserId);

        return $this->response->paginator($messageList, $this->message_transformer);
    }
       
    public function syncMessages($id) {
        $input = $this->request->all();
        $messageObject = Message::where('id', $id)->first();
        $currentLoggedUser = app('logged_user');
        
        if (!$messageObject) {
            return Helper::notFoundErrorResponse(Helper::MESSAGE_NOT_FOUND,
                    Helper::MESSAGE_NOT_FOUND_TITLE,
                    Helper::MESSAGE_NOT_FOUND_MSG);
        }
        
        // Validate sync item
        $validate = $this->validateRequest('api-check-message-sync', $input);
        if ($validate !== true) {
            return $validate;
        }
        
        if (($messageObject->seller_id != $currentLoggedUser->appuser_id) && 
                ($messageObject->buyer_id != $currentLoggedUser->appuser_id)) {           
            return Helper::notFoundErrorResponse(Helper::USER_NOT_SELLER_BUYER_OF_ITEM,
                    Helper::USER_NOT_SELLER_BUYER_OF_ITEM_TITLE,
                    Helper::USER_NOT_SELLER_BUYER_OF_ITEM_MSG);
        }  
        $data = $input['chat'];
        if (isset($input['chat']) && count($input['chat']) > 0) {
            foreach ($input['chat'] as $key => $singleChat) {
                $data[$key]['message_id'] = $messageObject->id;
                $data[$key]['created_at'] = Carbon::now();
                $data[$key]['updated_at'] = Carbon::now();
            }
            
            // only create if inputed chat count bigger than current chat count
            if (count($input['chat']) > $messageObject->chat()->count()) {
                $messageObject->chat()->delete();
                $messageObject->chat()->insert($data);
            }
        }
        
        return $this->response->item($messageObject, $this->message_transformer);   
        
    }
    
    public function removeMessage($id) {
            
        $messageObject = Message::where('id', $id)->first();
        if (!$messageObject) {
            return Helper::notFoundErrorResponse(Helper::MESSAGE_NOT_FOUND,
                    Helper::MESSAGE_NOT_FOUND_TITLE,
                    Helper::MESSAGE_NOT_FOUND_MSG);
        }
        
        $currentLoggedUser = app('logged_user');
        
        if ($messageObject->seller_id == $currentLoggedUser->appuser_id) {
            $messageObject->seller_visibility = Message::VISIBILITY_HIDDEN;
            $messageObject->save();
        } else if ($messageObject->buyer_id == $currentLoggedUser->appuser_id) {
            $messageObject->buyer_visibility = Message::VISIBILITY_HIDDEN;
            $messageObject->save();
        } else {
            return Helper::notFoundErrorResponse(Helper::USER_NOT_SELLER_BUYER_OF_ITEM,
                    Helper::USER_NOT_SELLER_BUYER_OF_ITEM_TITLE,
                    Helper::USER_NOT_SELLER_BUYER_OF_ITEM_MSG);
        }       
        
        return $this->response->item($messageObject, $this->message_transformer);   
    }

    public function store() {
        $input =  $this->request->all();                     
        
        // Validate create new item
        $validate = $this->validateRequest('api-check-message-create', $input);
        if ($validate !== true) {
            return $validate;
        }
        
        $currentLoggedUser = app('logged_user');
               
        // Successfull validated data, start to create new message
        $itemObject = Item::where('id', $input['item_id'])->first();                
        
        $input['buyer_id'] = $currentLoggedUser->appuser_id;
        $input['seller_id'] = $itemObject->appuser_id;
        
        if ($input['buyer_id'] == $input['seller_id']) {
            return Helper::badRequestErrorResponse(Helper::CAN_NOT_CHAT_WITH_YOURSELF,
                    Helper::CAN_NOT_CHAT_WITH_YOURSELF_TITLE,
                    Helper::CAN_NOT_CHAT_WITH_YOURSELF_MSG);
        }
              
        // find existing chat message
        $existingMessage = Message::where('buyer_id', $currentLoggedUser->appuser_id)
                ->where('seller_id', $itemObject->appuser_id)
                ->where('item_id', $input['item_id'])
                ->first();
        
        if ($existingMessage) {
            return $this->response->item($existingMessage, $this->message_transformer); 
        }
        
        $createdMessage = $this->message_repository->create($input);
        
        $returnedItem = $this->message_repository->find($createdMessage->id);
     
        return $this->response->item($returnedItem, $this->message_transformer); 
    }     
}

