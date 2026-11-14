<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Initial Staff Administrator
    |--------------------------------------------------------------------------
    |
    | Used by the StaffSeeder to create the first administrator account. When
    | no password is configured a random one is generated and printed once.
    |
    */

    'admin' => [
        'name' => env('STAFF_ADMIN_NAME', 'Administrador'),
        'email' => env('STAFF_ADMIN_EMAIL', 'admin@coffeetec.test'),
        'password' => env('STAFF_ADMIN_PASSWORD'),
    ],

];
