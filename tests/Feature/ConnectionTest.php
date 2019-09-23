<?php

namespace Tests\Feature;

use DB;
use Tests\TestCase;

class ConnectionTest extends TestCase
{
  public function testCreate()
  {
    $connection = [
      'name' => 'test_connection_update',
      'driver' => 'pgsql',
      'host' => 'localhost',
      'port' => '3306',
      'username' => 'postgres',
      'password' => '',
      'database' => 'postgres',
      'schema' => 'public',
    ];

    $response = $this
      ->withRoot()
      ->post('/connections/create', $connection);

    $response
      ->assertStatus(201)
      ->assertJsonStructure(['message', 'data']);

    $connection['id'] = $response
      ->decodeResponseJson()['data']['id'];

    return $connection;
  }

  /**
   * @depends testCreate
   */
  public function testConnectionCreated($connection)
  {
    $response = $this
      ->withRoot()
      ->post('/connections/search');

    $response
      ->assertJsonFragment($connection);
  }

  /**
   * @depends testCreate
   */
  public function testUpdate($connection)
  {
    $connection = [
      'id' => $connection['id'],
      'name' => 'test_connection_updated',
      'driver' => 'pgsql',
      'host' => 'localhost',
      'port' => '3306',
      'username' => 'postgres',
      'password' => '123456',
      'database' => 'postgres',
      'schema' => 'public'
    ];

    $response = $this
      ->withRoot()
      ->post('/connections/update', $connection);

    $response
      ->assertStatus(201)
      ->assertJsonStructure(['message', 'data']);

    return $connection;
  }

  /**
   * @depends testUpdate
   */
  public function testConnectionUpdated($connection)
  {
    $response = $this
      ->withRoot()
      ->post('/connections/search');

    $response
      ->assertJsonFragment(['test_connection_updated']);
  }

  /**
   * @depends testCreate
   */
  public function testDelete($connection)
  {
    $response = $this
      ->withRoot()
      ->post('/connections/delete', ['id' => $connection['id']]);

    $response
      ->assertStatus(201)
      ->assertJsonStructure(['message']);

    return $connection;
  }

  /**
   * @depends testDelete
   */
  public function testConnectionDeleted($connection)
  {
    $response = $this
      ->withRoot()
      ->post('/connections/search');

    $response
      ->assertStatus(200)
      ->assertJsonMissingExact(['id' => $connection['id']]);
  }

  public function testSearch()
  {
    $response = $this
      ->withRoot()
      ->post('/connections/search');

    $response
      ->assertStatus(200)
      ->assertJsonStructure([]);
  }
}
