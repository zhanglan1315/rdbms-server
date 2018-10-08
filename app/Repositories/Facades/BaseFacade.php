<?php

namespace App\Repositories\Facades;

use Illuminate\Support\Facades\Facade;

class BaseFacade extends Facade
{
    // provide convenient interface for calling
    protected static function getFacadeAccessor()
    {
        return 'App\Repositories'.substr(get_called_class(), 24);
    }
}
