<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
	public function run()
	{
		DB::table('user')->insert([
			[
				'name' => 'zhanglan',
				'username' => 'zhanglan',
				'password' => 'aeoikj',
				'email' => 'delylaric@gmail.com',
				'roles' => array_encode([1, 2])
			]
		]);
	}
}
