<?php

namespace Modules\Notifications\Http\Controllers\Api;

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
use Modules\Notifications\Entities\Notifications;
use Modules\Appuser\Entities\AppuserDevice;
use Modules\Notify\Repositories\NotifyRepository;
use Modules\Notify\Entities\Notify;
use OneSignal;

class NotificationsController extends BaseController
{
    protected $module_name = 'notifications';
            
    public function __construct(Request $request,
            AppuserRepository $appuser,
            NotifyRepository $notifyRepository)
    {
        
        $this->request = $request;    
        $this->appuser = $appuser;
        $this->notify_repository = $notifyRepository;
    }
        
    
    public function sendScheduleNotification() {
        // Update item promote from 1 to 0 if featured_end_date < now
        $notificationId = Notifications::where('status', Notifications::STATUS_SCHEDULED)
                ->where('schedule_date_from', '<=', date("Y-m-d H:i:s"))
                ->where('schedule_date_to', '>=', date("Y-m-d H:i:s"))->pluck('id')->toArray();
        
        $notificationListToSend = Notifications::where('status', Notifications::STATUS_SCHEDULED)
                ->where('schedule_date_from', '<=', date("Y-m-d H:i:s"))
                ->where('schedule_date_to', '>=', date("Y-m-d H:i:s"))->get();
        
        if (count($notificationListToSend) > 0) {
            foreach ($notificationListToSend as $singleNotification) {
                $appUserList = $this->appuser->getAppuserMatchingBroadcastGroup($singleNotification->broadcast_id);
                
                if (count($appUserList) > 0) {
                    $arrayUserId = $appUserList->pluck('id')->toArray();
                     // Send push notification          
                    try {
                        $playerIdToSend = AppuserDevice::whereIn('appuser_id', $arrayUserId)
                                ->pluck('player_id')->toArray();

                        $deviceObjectToSend = AppuserDevice::whereIn('appuser_id', $arrayUserId)->groupBy('appuser_id')->get();

                        $heading = 'Notification from Handshake';
                        $message = $singleNotification->name;                    

                        if (count($playerIdToSend) > 0) {                
                            if (count($deviceObjectToSend)) {
                                foreach ($deviceObjectToSend as $singleDeviceObject) {
                                    $createdNotifyMessage = $this->notify_repository->create([
                                        'title' => $heading,
                                        'message' => $message,
                                        'sender_id' => null,
                                        'receiver_id' => $singleDeviceObject->appuser_id,
                                        'message_type' => Notify::TYPE_BROADCAST_PUSH
                                    ]);
                                }
                            }                 

                            $extraArray['type'] = Notify::TYPE_BROADCAST_PUSH;

                            /*
                            * Send Push notification to OneSignal
                            */                
                            OneSignal::sendNotificationToUser(
                                $message, 
                                $playerIdToSend, 
                                $heading, 
                                $extraArray
                            );  
                            \Log::info('cronjob NotificationsController - sendScheduleNotification - Push notification success to player id: ' . print_r($playerIdToSend, true));
                        }
                    } catch (\Exception $e) {
                        \Log::error('cronjob NotificationsController - sendScheduleNotification - Push notification error: ' . $e->getMessage());
                    }
                }                                   
            }            
        }        
        
        // Save Log
        Log::info('Run cronjob - NotificationsController - sendScheduleNotification, affected notification id: ' . print_r($notificationId, true));
                
    }
}

