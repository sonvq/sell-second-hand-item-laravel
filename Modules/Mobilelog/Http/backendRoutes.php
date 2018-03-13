<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/mobilelog'], function (Router $router) {
    $router->bind('mobilelog', function ($id) {
        return app('Modules\Mobilelog\Repositories\MobilelogRepository')->find($id);
    });
    $router->get('mobilelogs', [
        'as' => 'admin.mobilelog.mobilelog.index',
        'uses' => 'MobilelogController@index',
        'middleware' => 'can:mobilelog.mobilelogs.index'
    ]);
    $router->get('mobilelogs/create', [
        'as' => 'admin.mobilelog.mobilelog.create',
        'uses' => 'MobilelogController@create',
        'middleware' => 'can:mobilelog.mobilelogs.create'
    ]);
    $router->post('mobilelogs', [
        'as' => 'admin.mobilelog.mobilelog.store',
        'uses' => 'MobilelogController@store',
        'middleware' => 'can:mobilelog.mobilelogs.create'
    ]);
    $router->get('mobilelogs/{mobilelog}/edit', [
        'as' => 'admin.mobilelog.mobilelog.edit',
        'uses' => 'MobilelogController@edit',
        'middleware' => 'can:mobilelog.mobilelogs.edit'
    ]);
    $router->put('mobilelogs/{mobilelog}', [
        'as' => 'admin.mobilelog.mobilelog.update',
        'uses' => 'MobilelogController@update',
        'middleware' => 'can:mobilelog.mobilelogs.edit'
    ]);
    $router->delete('mobilelogs/{mobilelog}', [
        'as' => 'admin.mobilelog.mobilelog.destroy',
        'uses' => 'MobilelogController@destroy',
        'middleware' => 'can:mobilelog.mobilelogs.destroy'
    ]);
// append

});
