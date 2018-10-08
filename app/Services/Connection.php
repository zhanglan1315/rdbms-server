<?php

namespace App\Services;

class Connection
{
    protected $hasConfiged = false;

    public function config($config)
    {
        config(['database.connections.customer' => array_merge($config, [
            'charset'       => 'utf8',
            'collation'     => 'utf8_unicode_ci',
            'prefix'        => '',
            'strict'        => true,
            'engine'        => null
        ])]);
        config(['database.default' => 'customer']);
    }
}
