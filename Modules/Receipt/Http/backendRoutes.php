<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/receipt'], function (Router $router) {
    $router->bind('receipt', function ($id) {
        return app('Modules\Receipt\Repositories\ReceiptRepository')->find($id);
    });
    $router->get('receipts', [
        'as' => 'admin.receipt.receipt.index',
        'uses' => 'ReceiptController@index',
        'middleware' => 'can:receipt.receipts.index'
    ]);
    $router->get('receipts/create', [
        'as' => 'admin.receipt.receipt.create',
        'uses' => 'ReceiptController@create',
        'middleware' => 'can:receipt.receipts.create'
    ]);
    $router->post('receipts', [
        'as' => 'admin.receipt.receipt.store',
        'uses' => 'ReceiptController@store',
        'middleware' => 'can:receipt.receipts.create'
    ]);
    $router->get('receipts/{receipt}/edit', [
        'as' => 'admin.receipt.receipt.edit',
        'uses' => 'ReceiptController@edit',
        'middleware' => 'can:receipt.receipts.edit'
    ]);
    $router->put('receipts/{receipt}', [
        'as' => 'admin.receipt.receipt.update',
        'uses' => 'ReceiptController@update',
        'middleware' => 'can:receipt.receipts.edit'
    ]);
    $router->delete('receipts/{receipt}', [
        'as' => 'admin.receipt.receipt.destroy',
        'uses' => 'ReceiptController@destroy',
        'middleware' => 'can:receipt.receipts.destroy'
    ]);    
        
    $router->get('receipts/export', [
        'as' => 'admin.receipt.receipt.export', 
        'uses' => 'ReceiptController@export'
    ]);  
// append

});
