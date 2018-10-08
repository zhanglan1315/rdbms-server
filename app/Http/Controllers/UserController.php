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
		$name = $this->get('name', 'nullable');
		$email = $this->get('email', 'required');
		$password = $this->get('password', 'required');
		$username = $this->get('username', 'required|unique:user,username');

		DB::table('user')->insert([
			'name' => $name,
			'email' => $email,
			'username' => $username,
			'password' => $password,
		]);
	}
}
