<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

return [

    'api-check-appuser-register' => [
        'rules' => [
            'email' => 'required|max:30|email|unique:users,email|unique:appuser__appusers,email',
            'username' => 'required|max:255|unique:appuser__appusers,username',
            'full_name' => 'required|max:30',            
            'phone_number' => [
                'required', 
                'max:255',
                'unique:appuser__appusers,phone_number',
                'regex:/^\+?\d+$/',
            ],
            'password' => [
                'required',
                'max:255',
                'confirmed',
                'regex:/^(?=.*[A-Z])(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{6,12}$/',
                'min:6',
                'max:12'
            ],
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'required|date|before:18 years ago|date_format:Y-m-d',
            'city_id' => 'required|exists:city__cities,id',
            'country_id' => 'required|exists:country__countries,id'
        ],
        'messages' => [
            'password.regex' => 'Password need at least one capital, one special, between 6 and 12 character'
        ]
    ],    
    
    'api-check-appuser-update-personalization' => [
        'rules' => [
            'subcategory_id' => 'required',
        ],
        'messages' => [

        ]
    ],
    
    'api-check-login' => [
        'rules' => [
            'email' => 'required|email',
            'password' => 'required'
        ],
        'messages' => [

        ]
    ],
    
    'api-check-forgot-password' => [
        'rules' => [
            'email' => 'required|email',
        ],
        'messages' => [

        ]
    ],
    
    'api-check-change-password' => [
        'rules' => [
            'now_password' => 'required',
            'password' => [
                'required',
                'max:255',
                'confirmed',
                'regex:/^(?=.*[A-Z])(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{6,12}$/',
                'min:6',
                'max:12',
                'different:now_password'
            ],            
        ],
        'messages' => [
            'password.different' => 'The current password and new password must be different',
            'password.regex' => 'Password need at least one capital, one special, between 6 and 12 character'
        ]
    ]
];
