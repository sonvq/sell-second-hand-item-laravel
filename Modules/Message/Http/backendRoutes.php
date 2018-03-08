<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/message'], function (Router $router) {
    $router->bind('message', function ($id) {
        return app('Modules\Message\Repositories\MessageRepository')->find($id);
    });
    $router->get('messages', [
        'as' => 'admin.message.message.index',
        'uses' => 'MessageController@index',
        'middleware' => 'can:message.messages.index'
    ]);
    $router->get('messages/create', [
        'as' => 'admin.message.message.create',
        'uses' => 'MessageController@create',
        'middleware' => 'can:message.messages.create'
    ]);
    $router->post('messages', [
        'as' => 'admin.message.message.store',
        'uses' => 'MessageController@store',
        'middleware' => 'can:message.messages.create'
    ]);
    $router->get('messages/{message}/edit', [
        'as' => 'admin.message.message.edit',
        'uses' => 'MessageController@edit',
        'middleware' => 'can:message.messages.edit'
    ]);
    $router->put('messages/{message}', [
        'as' => 'admin.message.message.update',
        'uses' => 'MessageController@update',
        'middleware' => 'can:message.messages.edit'
    ]);
    $router->delete('messages/{message}', [
        'as' => 'admin.message.message.destroy',
        'uses' => 'MessageController@destroy',
        'middleware' => 'can:message.messages.destroy'
    ]);
// append
    $router->get('messages-export', [
        'as' => 'admin.message.message.export',
        'uses' => 'MessageController@export'
    ]);
});
