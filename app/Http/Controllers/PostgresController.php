<?php

namespace App\Http\Controllers;

use DB;
use Connection;
use Carbon\Carbon;

class PostgresController extends Controller
{
  protected $systemSchemas = [
    'pg_toast', 'pg_temp_1', 'pg_toast_temp_1',
  ];

  public function test()
  {
    $params = $this->via([
      'driver' => 'required',
      'host' => 'required',
      'port' => 'required',
      'username' => 'required',
      'password' => 'nullable',
      'database' => 'required',
      'schema' => 'nullable',
    ]);

    Connection::config($params);

    try {
      DB::select('select 100; /* for testing RDBMS connection */');
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
    $result = [];

    $databases = DB::table('pg_database')
      ->where('datistemplate', false)
      ->pluck('datname');

    return DB::select('SELECT schema_name FROM information_schema.schemata');

    return DB::table('pg_namespace')
    ->pluck('nspname');

    return ($databases);

    return $result;
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

  public function tableSearch()
  {
    $table = $this->get('table', 'required');
    $where = $this->get('where', 'nullable');
    $page = $this->get('page', 'nullable', 1);
    $perPage = $this->get('perPage', 'nullable', 200);

    $query = DB::table($table)
      ->select(DB::raw('count(*)'));
    $where && $query->whereRaw($where);
    $total = $query->pluck('count')->first();

    $query = DB::table($table)
      ->select('ctid', '*')
      ->limit($perPage)
      ->offset($perPage * ($page - 1));

    $where && $query->whereRaw($where);
    $sql = $query->toSql();

    $start = microtime(true);
    try {
      $result = DB::getPdo()->query($sql);
    } catch (\PDOException $e) {
      if ($e->getSqlState()) {
        return error_response([
          'state' => $e->getSqlState(),
          'message' => $e->getMessage()
        ]);
      }
    }
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

  public function tableUpdate()
  {
    $table = $this->get('table', 'required');
    $modifiers = $this->get('modifiers', 'required|array');

    foreach ($modifiers as $modifier) {
      DB::table($table)
        ->where($modifier['where'])
        ->update($modifier['set']);
    }

    return success_response('success to update table');
  }
}
