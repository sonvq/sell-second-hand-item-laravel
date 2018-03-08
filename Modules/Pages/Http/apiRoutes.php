<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    
    $api->group(['prefix' => '/pages', 'namespace' => 'Modules\Pages\Http\Controllers\Api'], function ()use ($api) {
                      
        
        $api->group(['middleware' => ['apis.frontend']], function () use ($api) {                        
                                                                    
        });
                

        $api->get('/pages', ['uses' => 'PagesController@index', 'as' => 'api.pages.index']);        
    });

});