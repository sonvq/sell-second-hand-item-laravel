<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    
    $api->group(['prefix' => '/mobilelog', 'namespace' => 'Modules\Mobilelog\Http\Controllers\Api'], function ()use ($api) {
              
        $api->post('/mobilelogs', ['uses' => 'MobilelogController@store', 'as' => 'api.mobilelog.store']);                                                        
    });

});