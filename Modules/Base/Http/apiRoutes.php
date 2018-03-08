<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    
    $api->group(['prefix' => '/base', 'namespace' => 'Modules\Base\Http\Controllers\Api'], function ()use ($api) {
      
        
        $api->group(['middleware' => ['apis.frontend']], function () use ($api) {                        
            $api->post('/upload-file', ['uses' => 'FileUploadController@uploadFile', 'as' => 'api.base.upload.file']);                        
        });
    });

});