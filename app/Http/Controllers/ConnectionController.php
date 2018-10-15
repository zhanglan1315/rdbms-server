<?php

namespace App\Http\Controllers;

use DB;
use JWT;

class ConnectionController extends Controller
{
  public function all()
  {
    $userId = JWT::tokenInfo()->id;

    return DB::table('connection')
      ->where('user_id', $userId)
      ->orderBy('id')
      ->get();
  }

  public function create()
  {
    $userId = JWT::tokenInfo()->id;

    $params = $this->via([
      'name' => 'required',
      'driver' => 'required',
      'host' => 'required',
      'port' => 'required',
      'username' => 'required',
      'password' => 'nullable',
      'database' => 'nullable',
      'schema' => 'nullable',
    ]);

    $params['user_id'] = $userId;

    $id = DB::table('connection')->insertGetId($params);

    return success_response([
      'message' => 'success to create connection',
      'data' => DB::table('connection')->where('id', $id)->first()
    ], 201);
  }

  public function destroy($id)
  {
    DB::table('connection')->where('id', $id)->delete();

    return success_response('success to delete connection', 201);
  }

  public function update($id)
  {
    $params = $this->via([
      'name' => 'required',
      'driver' => 'required',
      'host' => 'required',
      'port' => 'required',
      'username' => 'required',
      'password' => 'nullable',
      'database' => 'nullable',
      'schema' => 'nullable',
    ]);

    DB::table('connection')->where('id', $id)->update($params);

    return success_response([
      'message' => 'success to update connection',
      'data' => DB::table('connection')->where('id', $id)->first()
    ], 201);
  }
}
