<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class UserController extends Controller
{
	public function search()
	{
		$result = DB::table('user')
			->addSelect(['id', 'name', 'username', 'email'])
			->addSelect(DB::raw("to_json(roles) as roles"))
			->get();

		foreach ($result as $item) {
			$item->roles = json_decode($item->roles);
		}

		return $result;
	}

	public function create()
	{
		$pwd = $this->get('password', 'required');
		$email = $this->get('email', 'required|unique:email,address');
		$username = $this->get('username', 'required|unique:user,username');

		$userId = DB::table('user')->insertGetId([
			'name' => $username,
			'email' => $email,
			'password' => $pwd,
			'username' => $username,
		]);

		DB::table('email')->insert([
			'address' => $email,
			'user_id' => $userId
		]);
		
		return success_response('success to create account');
	}
}
