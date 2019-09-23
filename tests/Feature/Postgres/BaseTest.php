<?php

namespace Tests\Feature\Postgres;

use Test;

class BaseTest extends BaseCase
{
  public function testConnectionTest()
  {
    $keys = ['host', 'port', 'database', 'username', 'password'];
    $data = array_only((array) Test::postgresConnection(), $keys);

    $response = $this
      ->withRoot()
      ->post('postgres/test', $data);

    $response
      ->assertStatus(200)
      ->assertJsonStructure(['message']);
  }

  public function testStatement()
  {
    $response = $this
      ->withConnection('postgres/statement', [
        'sql' => 'select 100'
      ]);

    $response
      ->assertStatus(201)
      ->assertJsonStructure(['message']);
  }

  public function testSelect()
  {
    $response = $this
      ->withConnection('postgres/select', [
        'sql' => 'select 100'
      ]);

    $response
      ->assertStatus(200)
      ->assertJsonStructure([]);
  }
}
