<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/offer'], function (Router $router) {
    $router->bind('offer', function ($id) {
        return app('Modules\Offer\Repositories\OfferRepository')->find($id);
    });
    $router->get('offers', [
        'as' => 'admin.offer.offer.index',
        'uses' => 'OfferController@index',
        'middleware' => 'can:offer.offers.index'
    ]);
    $router->get('offers/create', [
        'as' => 'admin.offer.offer.create',
        'uses' => 'OfferController@create',
        'middleware' => 'can:offer.offers.create'
    ]);
    $router->post('offers', [
        'as' => 'admin.offer.offer.store',
        'uses' => 'OfferController@store',
        'middleware' => 'can:offer.offers.create'
    ]);
    $router->get('offers/{offer}/edit', [
        'as' => 'admin.offer.offer.edit',
        'uses' => 'OfferController@edit',
        'middleware' => 'can:offer.offers.edit'
    ]);
    $router->put('offers/{offer}', [
        'as' => 'admin.offer.offer.update',
        'uses' => 'OfferController@update',
        'middleware' => 'can:offer.offers.edit'
    ]);
    $router->delete('offers/{offer}', [
        'as' => 'admin.offer.offer.destroy',
        'uses' => 'OfferController@destroy',
        'middleware' => 'can:offer.offers.destroy'
    ]);
// append

});
