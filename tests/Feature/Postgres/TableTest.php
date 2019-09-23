<?php

namespace Tests\Feature\Postgres;

class TableTest extends BaseCase
{
  public function testGetTables()
  {
    $response = $this
      ->schema('public')
      ->database('postgres')
      ->withConnection('postgres/table/search');

    $response
      ->assertStatus(200)
      ->assertJsonStructure([]);
  }

  public function testCreateTable()
  {
    $table = 'test_table';

    $response = $this
      ->withConnection('postgres/table/create', [
        'name' => $table
      ]);

    $response
      ->assertStatus(201)
      ->assertJsonStructure(['message']);

    return $table;
  }

  /**
   * @depends testCreateTable
   */
  public function testDeleteTable($table)
  {
    $response = $this
      ->withConnection('postgres/table/delete', [
        'name' => $table
      ]);

    $response
      ->assertStatus(201)
      ->assertJsonStructure(['message']);
  }
}
