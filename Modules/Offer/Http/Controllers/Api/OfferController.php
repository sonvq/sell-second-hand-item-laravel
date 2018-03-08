<?php

namespace Modules\Offer\Http\Controllers\Api;

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
use Carbon\Carbon;
use Modules\Item\Entities\Item;
use Modules\Offer\Repositories\OfferRepository;
use Modules\Offer\Entities\Offer;
use Modules\Offer\Transformers\OfferTransformerInterface;
use Modules\Message\Entities\Message;
use Modules\Message\Repositories\MessageRepository;
use Modules\Appuser\Repositories\AppuserDeviceRepository;
use Modules\Notify\Repositories\NotifyRepository;
use Modules\Notify\Entities\Notify;
use OneSignal;
use Modules\Appuser\Entities\AppuserActivity;
use Modules\Email\Entities\Email;
use Illuminate\Support\Facades\Mail;

class OfferController extends BaseController
{
    protected $module_name = 'offer';
            
    public function __construct(Request $request,
            OfferRepository $offerRepository,
            OfferTransformerInterface $offerTransformer,
            MessageRepository $messageRepository,
            AppuserDeviceRepository $deviceRepository,
            NotifyRepository $notifyRepository)
    {
        $this->offer_repository = $offerRepository;
        $this->request = $request;     
        $this->offer_transformer = $offerTransformer;
        $this->message_repository = $messageRepository;
        $this->device_repository = $deviceRepository;
        $this->notify_repository = $notifyRepository;
        
    }
    
    public function makeOfferAgain($id) {
        $input =  $this->request->all();  
        $currentLoggedUser = app('logged_user');   
        
        // Validate create new item
        $validate = $this->validateRequest('api-make-offer-again', $input);
        if ($validate !== true) {
            return $validate;
        }
        
        $offerObject = Offer::where('item_id', $id)
                ->where('status', Offer::STATUS_DECLINED)
                ->where('buyer_id', $currentLoggedUser->appuser_id)->first();
        
        if (!$offerObject) {
            return Helper::notFoundErrorResponse(Helper::MAKE_OFFER_NOT_FOUND,
                    Helper::MAKE_OFFER_NOT_FOUND_TITLE,
                    Helper::MAKE_OFFER_NOT_FOUND_MSG);
        }
               
        
        if (($offerObject->buyer_id == $currentLoggedUser->appuser_id)){
            
            $offerObject->offer_number = $input['offer_number'];
            $offerObject->status = Offer::STATUS_PENDING;
            $offerObject->save(); 
            
            $itemObject = $offerObject->item;
            
            // Log register activity
            $userActivity = new AppuserActivity();
            $userActivity->appuser_id = $currentLoggedUser->appuser_id;
            $userActivity->action = AppuserActivity::ACTION_OFFER_ITEM_AGAIN;
            $userActivity->item_id = $itemObject->id;
            $userActivity->log_time = Carbon::now();
            $userActivity->save();
            
            // Send push notification with created offer            
            if ($itemObject) {
                try {
                    $playerIdToSend = $this->device_repository->getByAttributes(['appuser_id' => $itemObject->appuser_id])
                            ->pluck('player_id')->toArray();

                    $deviceObjectToSend = $this->device_repository->findByAttributes(['appuser_id' => $itemObject->appuser_id]);

                    $heading = 'Notification from Handshake';
                    $message = $currentLoggedUser->appuser->full_name . ' offered your ' . $itemObject->title .
                            ' again with ' . $input['offer_number'] . strtoupper($itemObject->price_currency) . '!';                    

                    if (count($playerIdToSend) > 0) {                

                        if ($deviceObjectToSend) {
                            $createdNotifyMessage = $this->notify_repository->create([
                                'title' => $heading,
                                'message' => $message,
                                'sender_id' => $currentLoggedUser->appuser_id,
                                'receiver_id' => $deviceObjectToSend->appuser_id,
                                'message_type' => Notify::TYPE_MAKE_OFFER_AGAIN
                            ]);
                        }                

                        $messageObject = Message::where('item_id', $itemObject->id)
                                ->where('seller_id', $itemObject->appuser_id)
                                ->where('buyer_id', $currentLoggedUser->appuser_id)->first();
                        
                        $extraArray['chat_url'] = null;
                        if ($messageObject) {
                            $extraArray['chat_url'] = $messageObject->chat_url;    
                        }
                        
                        $extraArray['offer_id'] = $offerObject->id;
                        $extraArray['item_id'] = $itemObject->id;
                        $extraArray['type'] = Notify::TYPE_MAKE_OFFER_AGAIN;

                        /*
                        * Send Push notification to OneSignal
                        */                
                        OneSignal::sendNotificationToUser(
                            $message, 
                            $playerIdToSend, 
                            $heading, 
                            $extraArray
                        );  
                        \Log::info('OfferController - makeOfferAgain - Push notification success to player id: ' . print_r($playerIdToSend, true));
                    }
                } catch (\Exception $e) {
                    \Log::error('OfferController - makeOfferAgain - Push notification error: ' . $e->getMessage());
                }
            }
            
            // Send email offer for item's owner
            $offerEmail = Email::where('type', Email::TYPE_NOTIFICATION_EMAIL)->where('status', Email::STATUS_PUBLISH)->first();
            $itemOwner = $itemObject->appuser;
            if ($offerEmail && $itemOwner) {

                $content = $offerEmail->content;
                $search = ['[full_name]', '[item_title]', '[price_currency]', '[offer_number]', '[offered_by]'];
                $replaceWith = [$itemOwner->full_name, $itemObject->title, $itemObject->price_currency, $input['offer_number'], $currentLoggedUser->appuser->full_name];
                $newContent = str_replace($search, $replaceWith, $content);            

                $subject = $offerEmail->subject;
                $searchSubject = ['[offered_by]', '[item_title]'];
                $replaceWithSubject = [$currentLoggedUser->appuser->full_name, $itemObject->title];
                $newSubject = str_replace($searchSubject, $replaceWithSubject, $subject);

                Mail::send('appuser::frontend.mail.mail_template', ['content' => $newContent], function ($m) use ($input, $newSubject, $itemOwner) {
                    $m->to($itemOwner->email)->subject($newSubject);
                });
                if (Mail::failures()) {
                    return Helper::internalServerErrorResponse(Helper::FAIL_TO_SEND_EMAIL,
                                Helper::FAIL_TO_SEND_EMAIL_TITLE,
                                Helper::FAIL_TO_SEND_EMAIL_MSG);
                } 
            }

            return $this->response->item($offerObject, $this->offer_transformer); 
        } 
        
        return Helper::badRequestErrorResponse(Helper::NOT_BUYER_OFFER,
                    Helper::NOT_BUYER_OFFER_TITLE,
                    Helper::NOT_BUYER_OFFER_MSG);
    }        
    
    public function index() {
        $input = $this->request->all();
        $perPage = (isset($input['per_page']) && $input['per_page'] > 0) ? $input['per_page'] : 15;
        $currentLoggedUser = app('logged_user');
        
        $currentUserId = null;
        if (!empty($currentLoggedUser)) {
            $currentUserId = $currentLoggedUser->appuser_id;
        }                 
        
        $offerList = $this->offer_repository->getOfferListing($input, $perPage, $currentUserId);

        return $this->response->paginator($offerList, $this->offer_transformer);
    }        
    
    public function changeOfferStatus($id) {
        $input =  $this->request->all();  
        
        // Validate offer item item
        $validate = $this->validateRequest('api-change-offer-status', $input);
        if ($validate !== true) {
            return $validate;
        }
        
        $offerObject = Offer::where('id', $id)->where('status', Offer::STATUS_PENDING)->first();
        if (!$offerObject) {
            return Helper::notFoundErrorResponse(Helper::OFFER_NOT_FOUND,
                    Helper::OFFER_NOT_FOUND_TITLE,
                    Helper::OFFER_NOT_FOUND_MSG);
        }
        
        $currentLoggedUser = app('logged_user');  
        
        if ($offerObject->seller_id != $currentLoggedUser->appuser_id) {
            return Helper::badRequestErrorResponse(Helper::OWNER_OF_ITEM_REQUIRED,
                    Helper::OWNER_OF_ITEM_REQUIRED_TITLE,
                    Helper::OWNER_OF_ITEM_REQUIRED_MSG);
        }
        
        $offerObject->status = $input['status'];
        $offerObject->save();
        $itemObject = $offerObject->item;
        if ($input['status'] == Offer::STATUS_ACCEPTED) {            
            if ($itemObject) {
                $itemObject->accepted_offer_id = $offerObject->id;
                $itemObject->sell_status = Item::SELL_STATUS_SOLD;
                $itemObject->save();
            }
            
            // Log accept offer item activity
            $userActivity = new AppuserActivity();
            $userActivity->appuser_id = $currentLoggedUser->appuser_id;
            $userActivity->action = AppuserActivity::ACTION_ACCEPT_ITEM;
            $userActivity->item_id = $itemObject->id;
            $userActivity->log_time = Carbon::now();
            $userActivity->save();
        } 
                                        
        // Send push notification with created offer
        try {
            $playerIdToSend = $this->device_repository->getByAttributes(['appuser_id' => $offerObject->buyer_id])
                    ->pluck('player_id')->toArray();

            $deviceObjectToSend = $this->device_repository->findByAttributes(['appuser_id' => $offerObject->buyer_id]);

            $heading = 'Notification from Handshake';
            
            if ($input['status'] == 'accepted') {
                $message = $currentLoggedUser->appuser->full_name . ' accepted your offered for ' . $itemObject->title . '!';
                $messageType = Notify::TYPE_ACCEPTED_OFFER;
            } else if ($input['status'] == 'declined') {
                $message = $currentLoggedUser->appuser->full_name . ' declined your offered for ' . $itemObject->title . '!';
                $messageType = Notify::TYPE_DECLINED_OFFER;
            }                                   

            if (count($playerIdToSend) > 0) {                

                if ($deviceObjectToSend) {
                    $createdNotifyMessage = $this->notify_repository->create([
                        'title' => $heading,
                        'message' => $message,
                        'sender_id' => $currentLoggedUser->appuser_id,
                        'receiver_id' => $deviceObjectToSend->appuser_id,
                        'message_type' => $messageType
                    ]);
                }                

                $messageObject = Message::where('item_id', $itemObject->id)
                                ->where('seller_id', $currentLoggedUser->appuser_id)
                                ->where('buyer_id', $offerObject->buyer_id)->first();
                        
                $extraArray['chat_url'] = null;
                if ($messageObject) {
                    $extraArray['chat_url'] = $messageObject->chat_url;    
                }
                
                $extraArray['offer_id'] = $offerObject->id;
                $extraArray['item_id'] = $itemObject->id;
                $extraArray['type'] = $messageType;


                /*
                * Send Push notification to OneSignal
                */                
                OneSignal::sendNotificationToUser(
                    $message, 
                    $playerIdToSend, 
                    $heading, 
                    $extraArray
                );  
                \Log::info('OfferController - changeOfferStatus - Push notification success to player id: ' . print_r($playerIdToSend, true));
            }
        } catch (\Exception $e) {
            \Log::error('OfferController - changeOfferStatus - Push notification error: ' . $e->getMessage());
        }
        
        return $this->response->item($offerObject, $this->offer_transformer);         
    }        
 
    public function store() {
        $input =  $this->request->all();                     
        
        // Validate create new offer
        $validate = $this->validateRequest('api-make-offer', $input);
        if ($validate !== true) {
            return $validate;
        }
        
        $currentLoggedUser = app('logged_user');    

        $itemObject = Item::where('id', $input['item_id'])->first();
        $input['seller_id'] = $itemObject->appuser_id;        

        if($currentLoggedUser->appuser_id == $input['seller_id']) {
            return Helper::badRequestErrorResponse(Helper::BUYER_AND_SELLER_CAN_NOT_BE_SAME,
                    Helper::BUYER_AND_SELLER_CAN_NOT_BE_SAME_TITLE,
                    Helper::BUYER_AND_SELLER_CAN_NOT_BE_SAME_MSG);
        }
        
        
        if ($itemObject->appuser_id != $input['seller_id']) {
            return Helper::badRequestErrorResponse(Helper::SELLER_ARE_NOT_ITEM_OWNER,
                    Helper::SELLER_ARE_NOT_ITEM_OWNER_TITLE,
                    Helper::SELLER_ARE_NOT_ITEM_OWNER_MSG);
        }
        
        // Find existing offer
        $existingOffer = Offer::where('seller_id', $input['seller_id'])
                ->where('buyer_id', $currentLoggedUser->appuser_id)
                ->where('item_id', $input['item_id'])
                ->first();
        
        if ($existingOffer) {
            return Helper::badRequestErrorResponse(Helper::ALREADY_OFFERED_THIS_ITEM,
                    Helper::ALREADY_OFFERED_THIS_ITEM_TITLE,
                    Helper::ALREADY_OFFERED_THIS_ITEM_MSG);
        }
        if (isset($input['chat_url'])) {
            if (!empty($input['chat_url'])) {
                // find existing chat message
                $existingMessage = Message::where('buyer_id', $currentLoggedUser->appuser_id)
                        ->where('seller_id', $itemObject->appuser_id)
                        ->where('item_id', $input['item_id'])
                        ->first();

                if (!$existingMessage) {
                    $data = [];
                    $data['chat_url'] = $input['chat_url'];
                    $data['buyer_id'] = $currentLoggedUser->appuser_id;
                    $data['seller_id'] = $itemObject->appuser_id;
                    $data['item_id'] = $itemObject->id;
                    $createdMessage = $this->message_repository->create($data);
                }

            }
            
        }
        $input['status'] = Offer::STATUS_PENDING;
        $input['buyer_id'] = $currentLoggedUser->appuser_id;
        
        $createdOffer = $this->offer_repository->create($input);
        
        // Log register activity
        $userActivity = new AppuserActivity();
        $userActivity->appuser_id = $currentLoggedUser->appuser_id;
        $userActivity->action = AppuserActivity::ACTION_OFFER_ITEM;
        $userActivity->item_id = $itemObject->id;
        $userActivity->log_time = Carbon::now();
        $userActivity->save();
        
        // Send push notification with created offer
        try {
            $playerIdToSend = $this->device_repository->getByAttributes(['appuser_id' => $itemObject->appuser_id])
                    ->pluck('player_id')->toArray();

            $deviceObjectToSend = $this->device_repository->findByAttributes(['appuser_id' => $itemObject->appuser_id]);

            $heading = 'Notification from Handshake';
            $message = $currentLoggedUser->appuser->full_name . ' offered your ' . $itemObject->title .
                            ' at ' . $input['offer_number'] . strtoupper($itemObject->price_currency) . '!';                       

            if (count($playerIdToSend) > 0) {                

                if ($deviceObjectToSend) {
                    $createdNotifyMessage = $this->notify_repository->create([
                        'title' => $heading,
                        'message' => $message,
                        'sender_id' => $currentLoggedUser->appuser_id,
                        'receiver_id' => $deviceObjectToSend->appuser_id,
                        'message_type' => Notify::TYPE_MAKE_OFFER
                    ]);
                }                

                $extraArray['chat_url'] = $input['chat_url'];
                $extraArray['offer_id'] = $createdOffer->id;
                $extraArray['item_id'] = $itemObject->id;
                $extraArray['type'] = Notify::TYPE_MAKE_OFFER;


                /*
                * Send Push notification to OneSignal
                */                
                OneSignal::sendNotificationToUser(
                    $message, 
                    $playerIdToSend, 
                    $heading, 
                    $extraArray
                );  
                \Log::info('OfferController - store - Push notification success to player id: ' . print_r($playerIdToSend, true));
            }
        } catch (\Exception $e) {
            \Log::error('OfferController - store - Push notification error: ' . $e->getMessage());
        }
        
        // Send email offer for item's owner
        $offerEmail = Email::where('type', Email::TYPE_NOTIFICATION_EMAIL)->where('status', Email::STATUS_PUBLISH)->first();
        $itemOwner = $itemObject->appuser;
        if ($offerEmail && $itemOwner) {
            
            $content = $offerEmail->content;
            $search = ['[full_name]', '[item_title]', '[price_currency]', '[offer_number]', '[offered_by]'];
            $replaceWith = [$itemOwner->full_name, $itemObject->title, $itemObject->price_currency, $input['offer_number'], $currentLoggedUser->appuser->full_name];
            $newContent = str_replace($search, $replaceWith, $content);            
            
            $subject = $offerEmail->subject;
            $searchSubject = ['[offered_by]', '[item_title]'];
            $replaceWithSubject = [$currentLoggedUser->appuser->full_name, $itemObject->title];
            $newSubject = str_replace($searchSubject, $replaceWithSubject, $subject);
                        
            Mail::send('appuser::frontend.mail.mail_template', ['content' => $newContent], function ($m) use ($input, $newSubject, $itemOwner) {
                $m->to($itemOwner->email)->subject($newSubject);
            });
            if (Mail::failures()) {
                return Helper::internalServerErrorResponse(Helper::FAIL_TO_SEND_EMAIL,
                            Helper::FAIL_TO_SEND_EMAIL_TITLE,
                            Helper::FAIL_TO_SEND_EMAIL_MSG);
            } 
        }
        
                        
        return $this->response->item($createdOffer, $this->offer_transformer); 
    }        


}

