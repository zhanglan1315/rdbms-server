<?php

namespace App\Http\Controllers;

use DB;
use JWT;
use Illuminate\Http\Request;

class AuthController extends Controller
{
	public function test()
	{
		$message = 'token is valid';

		return success_response($message, 200);
	}

	public function login()
	{
		$username = $this->get('username', 'required');
		$password = $this->get('password', 'required');

		$user = DB::table('user')
			->select('id', 'password')
			->where('username', $username)
			->first();

		if (!$user || $user->password !== $password) {
			$message = 'username or password is incorrect';

			return error_response($message, 403);
		}

		$result = JWT::generate($user->id);

		return success_response($result, 201);
	}

	public function refresh()
	{
		if (JWT::tokenInfo() === false) {
			$message = 'token is invalid';

			return error_response($message, 403);
		}

		$id = JWT::tokenInfo()->id;

		$result = JWT::generate($id);

		return success_response($result, 201);
	}
}
