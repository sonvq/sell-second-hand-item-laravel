<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

return [

    'api-check-mobilelog-create' => [
        'rules' => [
            'content' => 'required',
            'file_name' => 'required|max:255',
            'function_name' => 'required|max:255',
        ],
        'messages' => [

        ]
    ],       
    
    
    
];
