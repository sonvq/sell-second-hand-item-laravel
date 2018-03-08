<?php

namespace Modules\Notifications\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Notifications\Entities\Notifications;
use Modules\Notifications\Http\Requests\CreateNotificationsRequest;
use Modules\Notifications\Http\Requests\UpdateNotificationsRequest;
use Modules\Notifications\Repositories\NotificationsRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Broadcast\Entities\Broadcast;
use Modules\Appuser\Entities\Appuser;
use Modules\Appuser\Repositories\AppuserRepository;
use Modules\Appuser\Entities\AppuserDevice;
use Modules\Notify\Entities\Notify;
use Modules\Notify\Repositories\NotifyRepository;
use Modules\User\Contracts\Authentication;
use OneSignal;

class NotificationsController extends AdminBaseController
{
    /**
     * @var NotificationsRepository
     */
    private $notifications;

    public function __construct(NotificationsRepository $notifications, 
            AppuserRepository $appuser,
            NotifyRepository $notifyRepository,
            Authentication $auth)
    {
        parent::__construct();

        $this->notifications = $notifications;
        $this->appuser = $appuser;
        $this->notify_repository = $notifyRepository;
        $this->auth = $auth;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $notifications = Notifications::with('broadcast')->get();
        $broadcasts = Broadcast::orderBy('title', 'asc')->get();   
        
        return view('notifications::admin.notifications.index', compact('broadcasts', 'notifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $broadcasts = Broadcast::orderBy('title', 'asc')->pluck('title', 'id')->toArray();   
        return view('notifications::admin.notifications.create', compact('broadcasts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateNotificationsRequest $request
     * @return Response
     */
    public function store(CreateNotificationsRequest $request)
    {
        $currentLoggedUser = $this->auth->user();
        
        $input = $request->all();
        
        if (isset($input['schedule_date_from']) && !empty($input['schedule_date_from'])) {
            $dateFrom = \DateTime::createFromFormat('d/m/Y', $input['schedule_date_from']);
            $dateFromFormatted = $dateFrom->format('Y-m-d');
            $input['schedule_date_from'] = $dateFromFormatted;
            
        }
        
        if (isset($input['schedule_date_to']) && !empty($input['schedule_date_to'])) {
            $dateTo = \DateTime::createFromFormat('d/m/Y', $input['schedule_date_to']);
            $dateToFormatted = $dateTo->format('Y-m-d');
            $input['schedule_date_to'] = $dateToFormatted;
        }
        
        if (isset($input['schedule_date_from']) && empty($input['schedule_date_from'])) {
            $input['schedule_date_from'] = null;
        }
        
        if (isset($input['schedule_date_to']) && empty($input['schedule_date_to'])) {
            $input['schedule_date_to'] = null;
        }                
        
        // Send push notification to user immediately if channels is in-app pushnotification
        if ((isset($input['status']) && $input['status'] == Notifications::STATUS_PUBLISHED)
                && (isset($input['channels']) && $input['channels'] == 'in_app_notification')){                
            // Get appuser that match the broadcastObject
            $appUserList = $this->appuser->getAppuserMatchingBroadcastGroup($input['broadcast_id']);
            
            if (count($appUserList) > 0) {
                $arrayUserId = $appUserList->pluck('id')->toArray();
                
                // Send push notification          

                try {
                    $playerIdToSend = AppuserDevice::whereIn('appuser_id', $arrayUserId)
                            ->pluck('player_id')->toArray();

                    $deviceObjectToSend = AppuserDevice::whereIn('appuser_id', $arrayUserId)->groupBy('appuser_id')->get();

                    $heading = 'Notification from Handshake';
                    $message = $input['name'];                    

                    if (count($playerIdToSend) > 0) {                
                        if (count($deviceObjectToSend)) {
                            foreach ($deviceObjectToSend as $singleDeviceObject) {
                                $createdNotifyMessage = $this->notify_repository->create([
                                    'title' => $heading,
                                    'message' => $message,
                                    'sender_id' => $currentLoggedUser->id,
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
                        \Log::info('NotificationsController - store - Push notification success to player id: ' . print_r($playerIdToSend, true));
                    }
                } catch (\Exception $e) {
                    \Log::error('NotificationsController - store - Push notification error: ' . $e->getMessage());
                }
            }
        }
        
        $this->notifications->create($input);

        return redirect()->route('admin.notifications.notifications.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('notifications::notifications.title.notifications')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Notifications $notifications
     * @return Response
     */
    public function edit(Notifications $notifications)
    {
        $broadcasts = Broadcast::orderBy('title', 'asc')->pluck('title', 'id')->toArray();   
        return view('notifications::admin.notifications.edit', compact('notifications', 'broadcasts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Notifications $notifications
     * @param  UpdateNotificationsRequest $request
     * @return Response
     */
    public function update(Notifications $notifications, UpdateNotificationsRequest $request)
    {
        $currentLoggedUser = $this->auth->user();
        
        $input = $request->all();
        
        if (isset($input['schedule_date_from']) && !empty($input['schedule_date_from'])) {
            $dateFrom = \DateTime::createFromFormat('d/m/Y', $input['schedule_date_from']);
            $dateFromFormatted = $dateFrom->format('Y-m-d');
            $input['schedule_date_from'] = $dateFromFormatted;
            
        }
        
        if (isset($input['schedule_date_to']) && !empty($input['schedule_date_to'])) {
            $dateTo = \DateTime::createFromFormat('d/m/Y', $input['schedule_date_to']);
            $dateToFormatted = $dateTo->format('Y-m-d');
            $input['schedule_date_to'] = $dateToFormatted;
        }
        
        if ((isset($input['schedule_date_from']) && empty($input['schedule_date_from'])) || 
                (isset($input['status']) && $input['status'] != 'scheduled')){
            $input['schedule_date_from'] = null;
        }
        
        if ((isset($input['schedule_date_to']) && empty($input['schedule_date_to'])) ||
                (isset($input['status']) && $input['status'] != 'scheduled')) {
            $input['schedule_date_to'] = null;
        }
        
        // Send push notification to user immediately if channels is in-app pushnotification
        if ((isset($input['status']) && $input['status'] == Notifications::STATUS_PUBLISHED)
                && (isset($input['channels']) && $input['channels'] == 'in_app_notification')){                        
            // Get appuser that match the broadcastObject
            $appUserList = $this->appuser->getAppuserMatchingBroadcastGroup($input['broadcast_id']);
            if (count($appUserList) > 0) {
                $arrayUserId = $appUserList->pluck('id')->toArray();
                
                // Send push notification          

                try {
                    $playerIdToSend = AppuserDevice::whereIn('appuser_id', $arrayUserId)
                            ->pluck('player_id')->toArray();

                    $deviceObjectToSend = AppuserDevice::whereIn('appuser_id', $arrayUserId)->groupBy('appuser_id')->get();

                    $heading = 'Notification from Handshake';
                    $message = $input['name'];                    

                    if (count($playerIdToSend) > 0) {                
                        if (count($deviceObjectToSend)) {
                            foreach ($deviceObjectToSend as $singleDeviceObject) {
                                $createdNotifyMessage = $this->notify_repository->create([
                                    'title' => $heading,
                                    'message' => $message,
                                    'sender_id' => $currentLoggedUser->id,
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
                        \Log::info('NotificationsController - update - Push notification success to player id: ' . print_r($playerIdToSend, true));
                    }
                } catch (\Exception $e) {
                    \Log::error('NotificationsController - update - Push notification error: ' . $e->getMessage());
                }
            }
        }
        
        $this->notifications->update($notifications, $input);

        return redirect()->route('admin.notifications.notifications.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('notifications::notifications.title.notifications')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Notifications $notifications
     * @return Response
     */
    public function destroy(Notifications $notifications)
    {
        $this->notifications->destroy($notifications);

        return redirect()->route('admin.notifications.notifications.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('notifications::notifications.title.notifications')]));
    }
}
