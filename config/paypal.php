<?php 

return [

    /*
    |--------------------------------------------------------------------------
    | Sandbox mode settings
    |--------------------------------------------------------------------------
    |
    | Use sandbox mode for testing purposes
    |
    */

    'sandbox' => [
        'enabled'  => true,
        'form_url' => 'https://www.sandbox.paypal.com/cgi-bin/webscr',
        'email'    => 'necroniasandbox-facilitator@gmail.com'
    ],

    /*
    |--------------------------------------------------------------------------
    | Live settings
    |--------------------------------------------------------------------------
    |
    | ..
    |
    */

    'currency'   => 'USD',
    'form_url'   => 'https://www.paypal.com/cgi-bin/webscr',
    'email'      => 'necroniasandbox@gmail.com',
    'offers'     => [
        '3.99' => 200,
        '3.11' => 300
    ]
    
];