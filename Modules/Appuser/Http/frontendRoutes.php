<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->group(['prefix' => 'appuser'], function (Router $router) {
   
    $router->get('reset/{id}/{token}', ['as' => 'appuser.reset.complete', 'uses' => 'AppuserController@getResetComplete']);
    $router->post('reset/{id}/{token}', ['as' => 'appuser.reset.complete.post', 'uses' => 'AppuserController@postResetComplete']);
   
});
