<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/subcategory'], function (Router $router) {
    $router->bind('subcategory', function ($id) {
        return app('Modules\Subcategory\Repositories\SubcategoryRepository')->find($id);
    });
    $router->get('subcategories', [
        'as' => 'admin.subcategory.subcategory.index',
        'uses' => 'SubcategoryController@index',
        'middleware' => 'can:subcategory.subcategories.index'
    ]);
    $router->get('subcategories/create', [
        'as' => 'admin.subcategory.subcategory.create',
        'uses' => 'SubcategoryController@create',
        'middleware' => 'can:subcategory.subcategories.create'
    ]);
    $router->post('subcategories', [
        'as' => 'admin.subcategory.subcategory.store',
        'uses' => 'SubcategoryController@store',
        'middleware' => 'can:subcategory.subcategories.create'
    ]);
    $router->get('subcategories/{subcategory}/edit', [
        'as' => 'admin.subcategory.subcategory.edit',
        'uses' => 'SubcategoryController@edit',
        'middleware' => 'can:subcategory.subcategories.edit'
    ]);
    $router->put('subcategories/{subcategory}', [
        'as' => 'admin.subcategory.subcategory.update',
        'uses' => 'SubcategoryController@update',
        'middleware' => 'can:subcategory.subcategories.edit'
    ]);
    $router->delete('subcategories/{subcategory}', [
        'as' => 'admin.subcategory.subcategory.destroy',
        'uses' => 'SubcategoryController@destroy',
        'middleware' => 'can:subcategory.subcategories.destroy'
    ]);
// append

});
