<?php

namespace App\Services;

use DB;
use JWT;

class Test
{
  protected $root;

  protected $token;

  protected $postgresConnection;

  public function __construct()
  {
    $this->setRoot();
    $this->setToken();
    $this->setPostgresConnection();
  }

  private function setRoot()
  {
    $this->root = DB::table('user')
      ->where('username', 'root')
      ->select('id', 'username', 'email')
      ->first();
  }

  private function setToken()
  {
    $this->token = JWT::generate($this->root)['token'];
  }

  private function setPostgresConnection()
  {
    $this->postgresConnection = DB::table('connection')
      ->where(['user_id' => 0, 'name' => 'postgres'])
      ->first();
  }

  public function root()
  {
    return $this->root;
  }

  public function token()
  {
    return $this->token;
  }

  public function postgresConnection()
  {
    return $this->postgresConnection;
  }
}
