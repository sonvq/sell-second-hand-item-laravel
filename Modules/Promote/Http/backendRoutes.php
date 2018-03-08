<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/promote'], function (Router $router) {
    $router->bind('promote', function ($id) {
        return app('Modules\Promote\Repositories\PromoteRepository')->find($id);
    });
    $router->get('promotes', [
        'as' => 'admin.promote.promote.index',
        'uses' => 'PromoteController@index',
        'middleware' => 'can:promote.promotes.index'
    ]);
    $router->get('promotes/create', [
        'as' => 'admin.promote.promote.create',
        'uses' => 'PromoteController@create',
        'middleware' => 'can:promote.promotes.create'
    ]);
    $router->post('promotes', [
        'as' => 'admin.promote.promote.store',
        'uses' => 'PromoteController@store',
        'middleware' => 'can:promote.promotes.create'
    ]);
    $router->get('promotes/{promote}/edit', [
        'as' => 'admin.promote.promote.edit',
        'uses' => 'PromoteController@edit',
        'middleware' => 'can:promote.promotes.edit'
    ]);
    $router->put('promotes/{promote}', [
        'as' => 'admin.promote.promote.update',
        'uses' => 'PromoteController@update',
        'middleware' => 'can:promote.promotes.edit'
    ]);
    $router->delete('promotes/{promote}', [
        'as' => 'admin.promote.promote.destroy',
        'uses' => 'PromoteController@destroy',
        'middleware' => 'can:promote.promotes.destroy'
    ]);
// append

});
