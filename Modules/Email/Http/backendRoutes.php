<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/email'], function (Router $router) {
    $router->bind('email', function ($id) {
        return app('Modules\Email\Repositories\EmailRepository')->find($id);
    });
    $router->get('emails', [
        'as' => 'admin.email.email.index',
        'uses' => 'EmailController@index',
        'middleware' => 'can:email.emails.index'
    ]);
    $router->get('emails/create', [
        'as' => 'admin.email.email.create',
        'uses' => 'EmailController@create',
        'middleware' => 'can:email.emails.create'
    ]);
    $router->post('emails', [
        'as' => 'admin.email.email.store',
        'uses' => 'EmailController@store',
        'middleware' => 'can:email.emails.create'
    ]);
    $router->get('emails/{email}/edit', [
        'as' => 'admin.email.email.edit',
        'uses' => 'EmailController@edit',
        'middleware' => 'can:email.emails.edit'
    ]);
    $router->put('emails/{email}', [
        'as' => 'admin.email.email.update',
        'uses' => 'EmailController@update',
        'middleware' => 'can:email.emails.edit'
    ]);
    $router->delete('emails/{email}', [
        'as' => 'admin.email.email.destroy',
        'uses' => 'EmailController@destroy',
        'middleware' => 'can:email.emails.destroy'
    ]);
// append

});
