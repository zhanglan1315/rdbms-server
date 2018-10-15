<?php

namespace App\Http\Middleware;

use DB;
use JWT;
use Closure;
use Connection;

class Postgres
{
  public function handle($request, Closure $next)
  {
    $schema = $request->input('schema');
    $id = $request->input('connectionId');
    $database = $request->input('database');

    if (!is_numeric($id)) {
      $message = 'connectionId is illegal';

      return error_response($message, 422);
    }

    $connection = DB::table('connection')->where('id', $id)->first();

    if ($connection === null) {
      $message = 'connectionId is illegal';

      return error_response($message, 422);
    }

    if ($connection->driver !== 'pgsql') {
      $message = "My brother, You are calling error database driver";

      return error_response($message, 422);
    }

    $userId = JWT::tokenInfo()->id;

    if ($userId !== $connection->user_id) {
      $message = 'connectionId is illegal';

      return error_response($message, 422);
    }

    Connection::config([
      'driver' => 'pgsql',
      'host' => $connection->host,
      'port' => $connection->port,
      'username' => $connection->username,
      'password' => $connection->password,
      'schema' => $schema ? $schema : $connection->schema,
      'database' => $database ? $database : $connection->database
    ]);

    if ($this->testConnect()) {
      return $next($request);
    } else {
      return error_response('fail to connect database', 422);
    };
  }

  public function testConnect()
  {
    try {
      DB::select('select 100; /* for testing RDBMS connection */');

      return true;
    } catch (\Exception $error) {

      return false;
    }
  }
}
