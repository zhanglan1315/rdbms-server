<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
	protected $roles = [
		'developer', 'user'
	];

	public function run()
	{
		$data = [];

		foreach ($this->roles as $role) {
			$item = [];
			$item['name'] = $role;

			$data[] = $item;
		}

		DB::table('role')->insert($data);
	}
}
