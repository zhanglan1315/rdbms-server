<?php 

return [
    'default' => 'system',

    'connections' => [

        'system'     => [
            'driver'        => 'pgsql',
            'host'          => env('PGSQL_HOST'),
            'port'          => env('PGSQL_PORT'),
            'username'      => env('PGSQL_USERNAME'),
            'password'      => env('PGSQL_PASSWORD'),
            'database'      => env('PGSQL_DATABASE'),
            'charset'       => 'utf8',
            'collation'     => 'utf8_unicode_ci',
            'prefix'        => '',
            'strict'        => true,
            'engine'        => null
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations'    => 'migrations',
];
