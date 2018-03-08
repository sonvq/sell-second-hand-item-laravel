<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    
    $api->group(['prefix' => '/notifications', 'namespace' => 'Modules\Notifications\Http\Controllers\Api'], function ()use ($api) {
              
        $api->get('/send-schedule-notification', ['uses' => 'NotificationsController@sendScheduleNotification', 'as' => 'api.notifications.send.schedule.notifications']);                        
        
    });

});