<?php

return [

    'share-social-or-promote-in-list' => [
        'description' => 'item::items.choose-promote-method',
        'view' => 'item::admin.items.fields.choose-promote-method',
        'translatable' => false,
        'check_access'=>'setting.settings.isSuperAdmin',
    ],
    
    'default-facebook-promote-days' => [
        'description' => 'item::items.default-facebook-promote-days',
        'view' => 'item::admin.items.fields.default-facebook-promote-days',
        'translatable' => false,
        'check_access'=>'setting.settings.isSuperAdmin'
    ],
    
    'minimum-discount-for-promote' => [
        'description' => 'item::items.minimum-discount-for-promote',
        'view' => 'item::admin.items.fields.minimum-discount-for-promote',
        'translatable' => false,
        'check_access'=>'setting.settings.isSuperAdmin'
    ],
    'duration-display-for-promote' => [
        'description' => 'item::items.duration-display-for-promote',
        'view' => 'item::admin.items.fields.duration-display-for-promote',
        'translatable' => false,
        'check_access'=>'setting.settings.isSuperAdmin'
    ],
];
