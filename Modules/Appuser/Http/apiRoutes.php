<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    
    $api->group(['prefix' => '/appuser', 'namespace' => 'Modules\Appuser\Http\Controllers\Api'], function ()use ($api) {
        
        $api->get('/settings', ['uses' => 'AppuserController@settings', 'as' => 'api.appuser.settings']);
        
        $api->get('/delete-redundant-subcategory', ['uses' => 'AppuserController@deleteRedundantSubcategory', 'as' => 'api.appuser.delete.redundant.subcategory']);
        
        $api->get('/delete-redundant-category', ['uses' => 'AppuserController@deleteRedundantCategory', 'as' => 'api.appuser.delete.redundant.category']);
        
        $api->get('/correct-category-item', ['uses' => 'AppuserController@correctCategoryItem', 'as' => 'api.appuser.correct.category.item']);
        
        
        $api->post('/register', ['uses' => 'AppuserController@register', 'as' => 'api.appuser.register']);
        $api->post('/login', ['uses' => 'AppuserController@login', 'as' => 'api.appuser.login']);
        
        $api->get('/forgot-password', ['uses' => 'AppuserController@forgotPassword', 'as' => 'api.appuser.forgot.password']);
        
        $api->group(['middleware' => ['apis.frontend']], function () use ($api) {                        
            $api->get('/logout', ['uses' => 'AppuserController@logout', 'as' => 'api.appuser.logout']);                        
            $api->post('/change-password', ['uses' => 'AppuserController@changePassword', 'as' => 'api.appuser.change.password']);
            
            $api->post('/update-personalization', ['uses' => 'AppuserController@updatePersonalization', 'as' => 'api.appuser.update.personalization']);
            
            $api->get('/profile', ['uses' => 'AppuserController@getUserProfile', 'as' => 'api.appuser.profile']);
            
            $api->post('/update-profile', ['uses' => 'AppuserController@updateProfile', 'as' => 'api.appuser.update.profile']);            
        });
    });

});