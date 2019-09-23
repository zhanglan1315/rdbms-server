<?php

namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

class Test extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'App\Services\Test';
    }
}
