<?php

return [
    //Default tax rate
    'tax' => 12,

    //Shoppingcart database settings
    'database' => [

        'connection' => null,

        'table' => 'shoppingcart',
    ],

    //Destroy the car on user logout
    'destroy_on_logout' => false,

    //Default number format
    'format' => [

        'decimals' =>  2,

        'decimal_point' => '.',

        'thousands_separator' => ''
    ]
];