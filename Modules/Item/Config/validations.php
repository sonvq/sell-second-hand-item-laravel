<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

return [

    'api-check-item-create' => [
        'rules' => [
            'title' => 'required|max:30',
            'description' => 'required|max:255',
            'city_id' => 'required|exists:city__cities,id',
            'country_id' => 'required|exists:country__countries,id',
            'category_id' => 'required|exists:category__categories,id',
            'subcategory_id' => 'required|exists:subcategory__subcategories,id',
            'item_condition' => 'required|in:mint,10,9,8,7,6,5,4,3,2,1',
            'price_currency' => 'required|in:usd,mmk,hkd,cny,vnd,sgd',
            'price_number' => 'required|numeric|min:1|max:9999999999.99',
            'deliver' => 'required|in:self_collection,delivery',
            'meetup_location' => 'required|max:255',
            'latitude' => 'numeric',
            'longitude' => 'numeric'
        ],
        'messages' => [
           'price_number.max' => "The price number may not be greater than 9,999,999,999.99."
        ]
    ],       
    
    'api-check-item-update' => [
        'rules' => [
            'title' => 'max:30',
            'description' => 'max:255',
            'city_id' => 'exists:city__cities,id',
            'country_id' => 'exists:country__countries,id',
            'category_id' => 'exists:category__categories,id',
            'subcategory_id' => 'exists:subcategory__subcategories,id',
            'item_condition' => 'in:mint,10,9,8,7,6,5,4,3,2,1',
            'price_currency' => 'in:usd,mmk,hkd,cny,vnd,sgd',
            'price_number' => 'numeric|min:1|max:9999999999.99',
            'deliver' => 'in:self_collection,delivery',
            'meetup_location' => 'max:255',
            'latitude' => 'numeric',
            'longitude' => 'numeric',
            'discount_price_number' => 'numeric',
            'discount_percent' => 'numeric'
        ],
        'messages' => [
           'price_number.max' => "The price number may not be greater than 9,999,999,999.99."
        ]
    ],  
    
    'api-submit-promote-package' => [
        'rules' => [
            'promote_method' => 'required|in:social_promote,listing_promote',
            'promote_package' => 'required_if:promote_method,listing_promote|exists:promote__promotes,id',            
        ],
        'messages' => [
           
        ]
    ],
    
    'api-get-item-by-chat-url' => [
        'rules' => [
            'chat_url' => 'required|max:255',
        ],
        'messages' => [
           
        ]
    ], 
    
    
];
