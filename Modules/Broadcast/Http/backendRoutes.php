<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/broadcast'], function (Router $router) {
    $router->bind('broadcast', function ($id) {
        return app('Modules\Broadcast\Repositories\BroadcastRepository')->find($id);
    });
    $router->get('broadcasts', [
        'as' => 'admin.broadcast.broadcast.index',
        'uses' => 'BroadcastController@index',
        'middleware' => 'can:broadcast.broadcasts.index'
    ]);
    $router->get('broadcasts/create', [
        'as' => 'admin.broadcast.broadcast.create',
        'uses' => 'BroadcastController@create',
        'middleware' => 'can:broadcast.broadcasts.create'
    ]);
    $router->post('broadcasts', [
        'as' => 'admin.broadcast.broadcast.store',
        'uses' => 'BroadcastController@store',
        'middleware' => 'can:broadcast.broadcasts.create'
    ]);
    $router->get('broadcasts/{broadcast}/edit', [
        'as' => 'admin.broadcast.broadcast.edit',
        'uses' => 'BroadcastController@edit',
        'middleware' => 'can:broadcast.broadcasts.edit'
    ]);
    $router->put('broadcasts/{broadcast}', [
        'as' => 'admin.broadcast.broadcast.update',
        'uses' => 'BroadcastController@update',
        'middleware' => 'can:broadcast.broadcasts.edit'
    ]);
    $router->delete('broadcasts/{broadcast}', [
        'as' => 'admin.broadcast.broadcast.destroy',
        'uses' => 'BroadcastController@destroy',
        'middleware' => 'can:broadcast.broadcasts.destroy'
    ]);
// append

});
