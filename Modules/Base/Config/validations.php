<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

return [

    'api-check-file-upload' => [
        'rules' => [
            'file' => 'required|image|mimes:jpeg,bmp,png,gif|image_extension|max:10240',   
        ],
        'messages' => [
            
        ]
    ],       
    
];
