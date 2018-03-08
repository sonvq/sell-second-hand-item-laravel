<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    
    $api->group(['prefix' => '/reporting', 'namespace' => 'Modules\Reporting\Http\Controllers\Api'], function ()use ($api) {
               
        $api->group(['middleware' => ['apis.frontend']], function () use ($api) {                        
            
            $api->post('/reportings', ['uses' => 'ReportingController@create', 'as' => 'api.reporting.reportings.create']);
                        
        });
    });

});