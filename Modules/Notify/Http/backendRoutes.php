<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/notify'], function (Router $router) {
    $router->bind('notify', function ($id) {
        return app('Modules\Notify\Repositories\NotifyRepository')->find($id);
    });
    $router->get('notifies', [
        'as' => 'admin.notify.notify.index',
        'uses' => 'NotifyController@index',
        'middleware' => 'can:notify.notifies.index'
    ]);
    $router->get('notifies/create', [
        'as' => 'admin.notify.notify.create',
        'uses' => 'NotifyController@create',
        'middleware' => 'can:notify.notifies.create'
    ]);
    $router->post('notifies', [
        'as' => 'admin.notify.notify.store',
        'uses' => 'NotifyController@store',
        'middleware' => 'can:notify.notifies.create'
    ]);
    $router->get('notifies/{notify}/edit', [
        'as' => 'admin.notify.notify.edit',
        'uses' => 'NotifyController@edit',
        'middleware' => 'can:notify.notifies.edit'
    ]);
    $router->put('notifies/{notify}', [
        'as' => 'admin.notify.notify.update',
        'uses' => 'NotifyController@update',
        'middleware' => 'can:notify.notifies.edit'
    ]);
    $router->delete('notifies/{notify}', [
        'as' => 'admin.notify.notify.destroy',
        'uses' => 'NotifyController@destroy',
        'middleware' => 'can:notify.notifies.destroy'
    ]);
// append

});
