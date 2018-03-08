<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    
    $api->group(['prefix' => '/item', 'namespace' => 'Modules\Item\Http\Controllers\Api'], function ()use ($api) {
              
        $api->get('/items', ['uses' => 'ItemController@index', 'as' => 'api.item.index']);                        
        $api->get('/featured-items', ['uses' => 'ItemController@featuredItems', 'as' => 'api.item.featured.items']);                        
        $api->get('/featured-items-favorite', ['uses' => 'ItemController@featuredItemsFavorite', 'as' => 'api.item.featured.items.favorite']);                        
        $api->get('/items/{id}', ['uses' => 'ItemController@show', 'as' => 'api.item.show']);
        
        $api->get('/search-autocomplete', ['uses' => 'ItemController@searchAutocomplete', 'as' => 'api.item.search.autocomplete']);                                
                
        $api->get('/filter-items', ['uses' => 'ItemController@filterItems', 'as' => 'api.item.filter.items']);                        
        
        $api->get('/filter-items-autocomplete', ['uses' => 'ItemController@filterItemsAutocomplete', 'as' => 'api.item.filter.items']);                        
        
        $api->get('/update-expired-promote-item', ['uses' => 'ItemController@updateExpiredPromoteItem', 'as' => 'api.item.update.expired.promote.item']);                        
        
        $api->group(['middleware' => ['apis.frontend']], function () use ($api) {                        
            $api->post('/items', ['uses' => 'ItemController@store', 'as' => 'api.item.store']);                                    
            $api->post('/update-item/{id}', ['uses' => 'ItemController@update', 'as' => 'api.item.update']);                                    
            
            $api->post('/submit-promote-package/{id}', ['uses' => 'ItemController@submitPromotePackage', 'as' => 'api.item.submit.promote.package']);                                    
            
            $api->post('/toggle-favorite-item/{id}', ['uses' => 'ItemController@toggleFavorite', 'as' => 'api.item.toggle.favorite']);
            
            $api->get('/search-autocomplete-favorite', ['uses' => 'ItemController@searchAutocompleteFavorite', 'as' => 'api.item.search.autocomplete.favorite']);                                   
            
            $api->get('/favorite-items', ['uses' => 'ItemController@getFavoriteItemList', 'as' => 'api.item.get.favorite.item.list']);                        
            
            $api->post('/mark-item-as-sold/{id}', ['uses' => 'ItemController@markItemAsSold', 'as' => 'api.item.mark.item.as.sold']);                        
            
            $api->get('/my-history', ['uses' => 'ItemController@myHistory', 'as' => 'api.item.my.history']);      
            
            $api->post('/get-item-by-chat-url', ['uses' => 'ItemController@getItemByChatUrl', 'as' => 'api.item.get.item.by.chat.url']);
        });
    });

});