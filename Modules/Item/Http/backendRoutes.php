<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/item'], function (Router $router) {
    $router->bind('item', function ($id) {
        return app('Modules\Item\Repositories\ItemRepository')->find($id);
    });
    $router->get('items', [
        'as' => 'admin.item.item.index',
        'uses' => 'ItemController@index',
        'middleware' => 'can:item.items.index'
    ]);
    $router->get('items/create', [
        'as' => 'admin.item.item.create',
        'uses' => 'ItemController@create',
        'middleware' => 'can:item.items.create'
    ]);
    $router->post('items', [
        'as' => 'admin.item.item.store',
        'uses' => 'ItemController@store',
        'middleware' => 'can:item.items.create'
    ]);
    $router->get('items/{item}/edit', [
        'as' => 'admin.item.item.edit',
        'uses' => 'ItemController@edit',
        'middleware' => 'can:item.items.edit'
    ]);
    $router->put('items/{item}', [
        'as' => 'admin.item.item.update',
        'uses' => 'ItemController@update',
        'middleware' => 'can:item.items.edit'
    ]);
    $router->delete('items/{item}', [
        'as' => 'admin.item.item.destroy',
        'uses' => 'ItemController@destroy',
        'middleware' => 'can:item.items.destroy'
    ]);
    
    $router->get('items/export', [
        'as' => 'admin.item.item.export', 
        'uses' => 'ItemController@export'
    ]);   
// append

});
