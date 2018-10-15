<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConnectionSeeder extends Seeder
{
  public function run()
  {
    $data = [];

    foreach ([1, 2, 3, 4, 5] as $index) {
      $data[] = [
        'name'      => 'Database ' . $index,
        'user_id'   => 1,
        'driver'    => 'pgsql',
        'host'      => 'localhost',
        'port'      => '5432',
        'username'  => 'postgres',
        'password'  => 'aeoikj_9217',
        'database'  => 'postgres',
        'schema'    => 'public',
      ];
    }

    DB::table('connection')->insert($data);
  }
}
