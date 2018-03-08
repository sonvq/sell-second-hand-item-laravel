<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/city'], function (Router $router) {
    $router->bind('city', function ($id) {
        return app('Modules\City\Repositories\CityRepository')->find($id);
    });
    $router->get('cities', [
        'as' => 'admin.city.city.index',
        'uses' => 'CityController@index',
        'middleware' => 'can:city.cities.index'
    ]);
    $router->get('cities/create', [
        'as' => 'admin.city.city.create',
        'uses' => 'CityController@create',
        'middleware' => 'can:city.cities.create'
    ]);
    $router->post('cities', [
        'as' => 'admin.city.city.store',
        'uses' => 'CityController@store',
        'middleware' => 'can:city.cities.create'
    ]);
    $router->get('cities/{city}/edit', [
        'as' => 'admin.city.city.edit',
        'uses' => 'CityController@edit',
        'middleware' => 'can:city.cities.edit'
    ]);
    $router->put('cities/{city}', [
        'as' => 'admin.city.city.update',
        'uses' => 'CityController@update',
        'middleware' => 'can:city.cities.edit'
    ]);
    $router->delete('cities/{city}', [
        'as' => 'admin.city.city.destroy',
        'uses' => 'CityController@destroy',
        'middleware' => 'can:city.cities.destroy'
    ]);
// append

});
