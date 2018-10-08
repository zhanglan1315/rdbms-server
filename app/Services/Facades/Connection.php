<?php

namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

class Connection extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'App\Services\Connection';
    }
}
