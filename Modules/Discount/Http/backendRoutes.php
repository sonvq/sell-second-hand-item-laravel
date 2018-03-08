<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/discount'], function (Router $router) {
    $router->bind('discount', function ($id) {
        return app('Modules\Discount\Repositories\DiscountRepository')->find($id);
    });
    $router->get('discounts', [
        'as' => 'admin.discount.discount.index',
        'uses' => 'DiscountController@index',
        'middleware' => 'can:discount.discounts.index'
    ]);
    $router->get('discounts/create', [
        'as' => 'admin.discount.discount.create',
        'uses' => 'DiscountController@create',
        'middleware' => 'can:discount.discounts.create'
    ]);
    $router->post('discounts', [
        'as' => 'admin.discount.discount.store',
        'uses' => 'DiscountController@store',
        'middleware' => 'can:discount.discounts.create'
    ]);
    $router->get('discounts/{discount}/edit', [
        'as' => 'admin.discount.discount.edit',
        'uses' => 'DiscountController@edit',
        'middleware' => 'can:discount.discounts.edit'
    ]);
    $router->put('discounts/{discount}', [
        'as' => 'admin.discount.discount.update',
        'uses' => 'DiscountController@update',
        'middleware' => 'can:discount.discounts.edit'
    ]);
    $router->delete('discounts/{discount}', [
        'as' => 'admin.discount.discount.destroy',
        'uses' => 'DiscountController@destroy',
        'middleware' => 'can:discount.discounts.destroy'
    ]);
// append

});
