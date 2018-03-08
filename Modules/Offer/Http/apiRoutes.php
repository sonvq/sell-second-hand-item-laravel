<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    
    $api->group(['prefix' => '/offer', 'namespace' => 'Modules\Offer\Http\Controllers\Api'], function ()use ($api) {
                      
        
        $api->group(['middleware' => ['apis.frontend']], function () use ($api) {                        
            $api->post('/make-offer', ['uses' => 'OfferController@store', 'as' => 'api.offer.store']);                                    
            
            $api->post('/make-offer-again/{id}', ['uses' => 'OfferController@makeOfferAgain', 'as' => 'api.offer.make.offer.again']);                                    
            
            $api->get('/offers', ['uses' => 'OfferController@index', 'as' => 'api.offer.index']);                                    
            $api->post('/change-offer-status/{id}', ['uses' => 'OfferController@changeOfferStatus', 'as' => 'api.offer.change.offer.status']);                                                                                                                   
                                                            
        });
    });

});