<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

return [

    'api-make-offer' => [
        'rules' => [
            'offer_number' => 'required|numeric|bigger_than:0|max:9999999999.99',
            'item_id' => 'required|exists:item__items,id',
            'chat_url' => 'required|max:255'
        ],
        'messages' => [
           'offer_number.max' => "The offer number may not be greater than 9,999,999,999.99."
        ]
    ],  
    
    'api-make-offer-again' => [
        'rules' => [
            'offer_number' => 'required|numeric|bigger_than:0|max:9999999999.99'
        ],
        'messages' => [
           'offer_number.max' => "The offer number may not be greater than 9,999,999,999.99."
        ]
    ],  
    
    'api-change-offer-status' => [
        'rules' => [
            'status' => 'required|in:accepted,declined',
        ],
        'messages' => [
           
        ]
    ],  
       
];
