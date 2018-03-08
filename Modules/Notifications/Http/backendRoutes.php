<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/notifications'], function (Router $router) {
    $router->bind('notifications', function ($id) {
        return app('Modules\Notifications\Repositories\NotificationsRepository')->find($id);
    });
    $router->get('notifications', [
        'as' => 'admin.notifications.notifications.index',
        'uses' => 'NotificationsController@index',
        'middleware' => 'can:notifications.notifications.index'
    ]);
    $router->get('notifications/create', [
        'as' => 'admin.notifications.notifications.create',
        'uses' => 'NotificationsController@create',
        'middleware' => 'can:notifications.notifications.create'
    ]);
    $router->post('notifications', [
        'as' => 'admin.notifications.notifications.store',
        'uses' => 'NotificationsController@store',
        'middleware' => 'can:notifications.notifications.create'
    ]);
    $router->get('notifications/{notifications}/edit', [
        'as' => 'admin.notifications.notifications.edit',
        'uses' => 'NotificationsController@edit',
        'middleware' => 'can:notifications.notifications.edit'
    ]);
    $router->put('notifications/{notifications}', [
        'as' => 'admin.notifications.notifications.update',
        'uses' => 'NotificationsController@update',
        'middleware' => 'can:notifications.notifications.edit'
    ]);
    $router->delete('notifications/{notifications}', [
        'as' => 'admin.notifications.notifications.destroy',
        'uses' => 'NotificationsController@destroy',
        'middleware' => 'can:notifications.notifications.destroy'
    ]);
// append

});
