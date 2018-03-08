<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    
    $api->group(['prefix' => '/message', 'namespace' => 'Modules\Message\Http\Controllers\Api'], function ()use ($api) {
                                           
        
        $api->group(['middleware' => ['apis.frontend']], function () use ($api) {         
            $api->get('/messages', ['uses' => 'MessageController@index', 'as' => 'api.message.messages.index']); 
            $api->post('/remove-message/{id}', ['uses' => 'MessageController@removeMessage', 'as' => 'api.message.remove.message']); 
            $api->post('/messages', ['uses' => 'MessageController@store', 'as' => 'api.message.messages.store']); 
            $api->post('/sync-messages/{id}', ['uses' => 'MessageController@syncMessages', 'as' => 'api.message.messages.sync']); 
        });
    });

});