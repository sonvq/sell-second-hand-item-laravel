<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/country'], function (Router $router) {
    $router->bind('country', function ($id) {
        return app('Modules\Country\Repositories\CountryRepository')->find($id);
    });
    $router->get('countries', [
        'as' => 'admin.country.country.index',
        'uses' => 'CountryController@index',
        'middleware' => 'can:country.countries.index'
    ]);
    $router->get('countries/create', [
        'as' => 'admin.country.country.create',
        'uses' => 'CountryController@create',
        'middleware' => 'can:country.countries.create'
    ]);
    $router->post('countries', [
        'as' => 'admin.country.country.store',
        'uses' => 'CountryController@store',
        'middleware' => 'can:country.countries.create'
    ]);
    $router->get('countries/{country}/edit', [
        'as' => 'admin.country.country.edit',
        'uses' => 'CountryController@edit',
        'middleware' => 'can:country.countries.edit'
    ]);
    $router->put('countries/{country}', [
        'as' => 'admin.country.country.update',
        'uses' => 'CountryController@update',
        'middleware' => 'can:country.countries.edit'
    ]);
    $router->delete('countries/{country}', [
        'as' => 'admin.country.country.destroy',
        'uses' => 'CountryController@destroy',
        'middleware' => 'can:country.countries.destroy'
    ]);
// append

});
