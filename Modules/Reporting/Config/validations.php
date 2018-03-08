<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

return [

    'api-create-reporting' => [
        'rules' => [
            'receiver_id' => 'required|exists:appuser__appusers,id',
            'reporting_reason_id' => 'required|exists:reporting__reasons,id',
            'item_id' => 'required|exists:item__items,id',                        
        ],
        'messages' => [
        ]
    ],    
    
];
