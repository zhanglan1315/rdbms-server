<?php

namespace Tests\Feature\Postgres;

class DatabaseTest extends BaseCase
{
  public function testSearchDatabase()
  {
    $response = $this
      ->withConnection('postgres/database/search');

    $response
      ->assertStatus(200)
      ->assertJsonFragment(['postgres']);
  }

  public function testCreateDatabase()
  {
    $database = 'test_database';

    $response = $this
      ->withConnection('postgres/database/create', [
        'name' => $database
      ]);

    $response
      ->assertStatus(201)
      ->assertJsonStructure(['message']);

    return $database;
  }

  /**
   * @depends testCreateDatabase
   */
  public function testDatabaseCreated($database)
  {
    $response = $this
      ->withConnection('postgres/database/search');

    $response
      ->assertStatus(200)
      ->assertJsonFragment([$database]);
  }

  /**
   * @depends testCreateDatabase
   */
  public function testRenameDatabase($database)
  {
    $rename = 'test_database_rename';

    $response = $this
      ->withConnection('postgres/database/rename', [
        'name' => $database,
        'rename' => $rename
      ]);

    $response
      ->assertStatus(201)
      ->assertJsonStructure(['message']);

    return $rename;
  }

  /**
   * @depends testRenameDatabase
   */
  public function testDatabaseRenamed($database)
  {
    $response = $this
      ->withConnection('postgres/database/search');

    $response
      ->assertStatus(200)
      ->assertJsonFragment([$database]);
  }

  /**
   * @depends testRenameDatabase
   */
  public function testDeleteDatabase($database)
  {
    $response = $this
      ->withConnection('postgres/database/delete', [
        'name' => $database
      ]);

    $response
      ->assertStatus(201)
      ->assertJsonStructure(['message']);

    return $database;
  }

  /**
   * @depends testDeleteDatabase
   */
  public function testDatabaseDeleted($database)
  {
    $response = $this
      ->withConnection('postgres/database/search');

    $response
      ->assertStatus(200)
      ->assertJsonMissingExact([$database]);
  }
}
