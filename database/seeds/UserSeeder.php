<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
	public function run()
	{
		$id = DB::table('user')->insert([
			[
				'name' => 'zhanglan',
				'username' => 'zhanglan',
				'password' => 'aeoikj',
				'email' => 'delylaric@gmail.com',
				'roles' => array_encode([1, 2])
			]
		]);

		DB::table('email')->insert([
			'user_id' => $id,
			'is_verified' => true,
			'address' => 'delylaric@gmail.com'
		]);
	}
}
