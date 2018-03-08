<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/appuser'], function (Router $router) {
    $router->bind('appuser', function ($id) {
        return app('Modules\Appuser\Repositories\AppuserRepository')->find($id);
    });
    $router->get('appusers', [
        'as' => 'admin.appuser.appuser.index',
        'uses' => 'AppuserController@index',
        'middleware' => 'can:appuser.appusers.index'
    ]);
    $router->get('appusers/create', [
        'as' => 'admin.appuser.appuser.create',
        'uses' => 'AppuserController@create',
        'middleware' => 'can:appuser.appusers.create'
    ]);
    $router->post('appusers', [
        'as' => 'admin.appuser.appuser.store',
        'uses' => 'AppuserController@store',
        'middleware' => 'can:appuser.appusers.create'
    ]);
    $router->get('appusers/{appuser}/edit', [
        'as' => 'admin.appuser.appuser.edit',
        'uses' => 'AppuserController@edit',
        'middleware' => 'can:appuser.appusers.edit'
    ]);
    $router->put('appusers/{appuser}', [
        'as' => 'admin.appuser.appuser.update',
        'uses' => 'AppuserController@update',
        'middleware' => 'can:appuser.appusers.edit'
    ]);
    $router->delete('appusers/{appuser}', [
        'as' => 'admin.appuser.appuser.destroy',
        'uses' => 'AppuserController@destroy',
        'middleware' => 'can:appuser.appusers.destroy'
    ]);
    
    $router->get('appusers/export', [
        'as' => 'admin.appuser.appuser.export', 
        'uses' => 'AppuserController@export'
    ]); 
    
    $router->get('appusers/user-info', [
        'as' => 'admin.appuser.appuser.user.info.by.id', 
        'uses' => 'AppuserController@userInfoById'
    ]); 
    
// append

});
