<?php

namespace App\Http\Controllers;

use DB;
use Connection;
use Carbon\Carbon;

class PostgresController extends Controller
{
  protected $systemSchemas = [
    'pg_toast', 'pg_temp_1', 'pg_toast_temp_1',
    'pg_catalog', 'information_schema'
  ];

  public function test()
  {
    $params = $this->via([
      'driver' => 'required',
      'host' => 'required',
      'port' => 'required',
      'username' => 'required',
      'password' => 'nullable',
      'database' => 'required'
    ]);

    Connection::config($params);

    try {
      DB::select('select 100');
      return success_response('success to connect database');
    } catch (\Exception $e) {
      return error_response('fail to connect database');
    }
  }

  public function databases()
  {
    $databases = DB::table('pg_database')
      ->where('datistemplate', false)
      ->pluck('datname');

    return $databases;
  }

  public function schemas()
  {
    return DB::table('pg_namespace')
      ->whereNotIn('nspname', $this->systemSchemas)
      ->pluck('nspname');
  }

  public function tables()
  {
    $schema = $this->get('schema', 'required');

    return DB::table('information_schema.tables as t')
      ->select('table_name as name')
      ->where('table_type', 'BASE TABLE')
      ->where('table_schema', $schema)
      ->pluck('name');
  }

  public function all()
  {
    config(['database.connections.customer.database' => 'postgres']);

    return DB::table('migrations')->get();
  }

  public function select()
  {
    $sql = $this->get('sql', 'required');
    $query = DB::getPdo()->query($sql);

    $columns = [];
    $columnColumns = $query->columnCount();

    for ($i = 0; $i < $columnColumns; $i++) {
      $column = $query->getColumnMeta($i);

      $columns[] = [
        'name' => $column['name'],
        'type' => $column['native_type']
      ];
    }

    return [
      'columns' => $columns,
      'data' => $query->fetchAll(\PDO::FETCH_NUM)
    ];
  }

  public function table()
  {
    $table = $this->get('table', 'required');
    $page = $this->get('page', 'nullable', 1);
    $perPage = $this->get('perPage', 'nullable', 200);

    $config = [];

    $total = DB::table($table)
      ->select(DB::raw('count(*)'))
      ->pluck('count')->first();

    $sql = DB::table($table)
      ->select('ctid', '*')
      ->limit($perPage)
      ->offset($perPage * ($page - 1))
      ->toSql();

    $start = microtime(true);

    $result = DB::getPdo()->query($sql);

    $time = ((int)((microtime(true) - $start) * 1000)) / 1000; // 保留三位小数

    $columns = [];
    for ($i = 0, $L = $result->columnCount(); $i < $L; $i++) {
      $column = $result->getColumnMeta($i);

      $columns[] = [
        'name' => $column['name'],
        'type' => $column['native_type']
      ];
    }

    return [
      'sql' => $sql,
      'page' => $page,
      'time' => $time,
      'total' => $total,
      'perPage' => $perPage,
      'columns' => $columns,
      'data' => $result->fetchAll(\PDO::FETCH_NUM),
    ];
  }
}
