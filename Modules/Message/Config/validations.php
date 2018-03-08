<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

return [
    
    
    'api-check-message-create' => [
        'rules' => [
            'chat_url' => 'required|max:255',
            'item_id' => 'required|exists:item__items,id'
        ],
        'messages' => [
           
        ]
    ], 
    
    'api-check-message-sync' => [
        'rules' => [
            'chat' => 'required|array',
            'chat.*.sender_id' => 'required|exists:appuser__appusers,id',
            'chat.*.message_content' => 'required',
            'chat.*.sent_time' => 'required|date|date_format:"Y-m-d H:i:s"',
            'chat.*.message_type' => 'required|in:image,text'
        ],
        'messages' => [
           
        ]
    ]
];
