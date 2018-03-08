<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/pages'], function (Router $router) {
    $router->bind('pages', function ($id) {
        return app('Modules\Pages\Repositories\PagesRepository')->find($id);
    });
    $router->get('pages', [
        'as' => 'admin.pages.pages.index',
        'uses' => 'PagesController@index',
        'middleware' => 'can:pages.pages.index'
    ]);
    $router->get('pages/create', [
        'as' => 'admin.pages.pages.create',
        'uses' => 'PagesController@create',
        'middleware' => 'can:pages.pages.create'
    ]);
    $router->post('pages', [
        'as' => 'admin.pages.pages.store',
        'uses' => 'PagesController@store',
        'middleware' => 'can:pages.pages.create'
    ]);
    $router->get('pages/{pages}/edit', [
        'as' => 'admin.pages.pages.edit',
        'uses' => 'PagesController@edit',
        'middleware' => 'can:pages.pages.edit'
    ]);
    $router->put('pages/{pages}', [
        'as' => 'admin.pages.pages.update',
        'uses' => 'PagesController@update',
        'middleware' => 'can:pages.pages.edit'
    ]);
    $router->delete('pages/{pages}', [
        'as' => 'admin.pages.pages.destroy',
        'uses' => 'PagesController@destroy',
        'middleware' => 'can:pages.pages.destroy'
    ]);
// append

});
