<?php

namespace App\Services;

use DB;

class Transaction
{
    public static $working = false;

    public static function begin()
    {
        // transaction has been started
        if (self::$working) return;

        DB::beginTransaction();
        self::$working = true;
    }

    public static function commit()
    {
        DB::commit();
        self::$working = false;
    }

    public static function rollback()
    {
        DB::rollback();
        self::$working = false;
    }

    public static function working()
    {
        return self::$working;
    }
}
