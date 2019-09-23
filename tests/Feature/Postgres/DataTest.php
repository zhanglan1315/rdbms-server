<?php

namespace Tests\Feature\Postgres;

class DataTest extends BaseCase
{
  public function test()
  {
    $this->assertTrue(true);
  }
  // protected $table = 'test_insert_table';

  // protected function search($params)
  // {
  //   $params['table'] = $this->table;

  //   return $this->withConnection('postgres/data/search', $params);
  // }

  // public function testCreateTable()
  // { 
  //   $response = $this
  //     ->withConnection('postgres/statement', [
  //       'sql' => "create table if not exists $this->table (
  //         id serial2,
  //         name varchar(255),
  //         email varchar(255),
  //         salary int
  //       )"
  //     ]);

  //   $response->assertStatus(201);
  // }

  // /**
  //  * @depends testCreateTable
  //  */
  // public function testStructure()
  // {
  //   $response = $this->search([
  //     'sort' => 'id',
  //     'columns' => '*',
  //   ]);

  //   dd ($response->decodeResponseJson());

  //   $response->assertStatus(200);
  // }

  // /**
  //  * @depends testCreateTable
  //  */
  // public function testDropTable()
  // {
  //   $response = $this
  //     ->withConnection('postgres/statement', [
  //       'sql' => "drop table if exists $this->table"
  //     ]);

  //   $response->assertStatus(201);
  // }

  // public function createTestTable()
  // {
  //   $response = $this
  //     ->withConnection('postgres/statement', [
  //       'sql' => "create table if not exists $this->table (
  //         id serial2,
  //         name varchar(255),
  //         email varchar(255)
  //       )"
  //     ]);

  //   $response
  //     ->assertStatus(201);
  // }

  // /**
  //  * @depends testCreateTestTable
  //  */
  // public function testInsertData()
  // {
  //   $this->createTestTable();

  //   $data = [
  //     ['name' => 'foo', 'email' => 'foo@test.com'],
  //     ['name' => 'bar', 'email' => 'bar@test.com']
  //   ];

  //   $response = $this
  //     ->withConnection('/postgres/data/insert', [
  //       'table' => $this->table,
  //       'data' => $data
  //     ]);

  //   $response
  //     ->assertStatus(201)
  //     ->assertJsonStructure(['message']);

  //   return $data;
  // }

  // /**
  //  * @depends testInsertData
  //  */
  // public function testDataInserted($data)
  // {
  //   $response = $this
  //     ->withConnection('/postgres/data/search', [
  //       'table' => $this->table,
  //       'format' => 'collection'
  //     ]);

  //   $response
  //     ->assertStatus(200)
  //     ->assertJsonFragment($data[0])
  //     ->assertJsonFragment($data[1]);

  //   $data = $response->decodeResponseJson()['result'];

  //   return $data;
  // }

  // /**
  //  * @depends testDataInserted
  //  */
  // public function testDataUpdate($data)
  // {
  //   $modifiers = array_map(function ($data) {
  //     return [
  //       'where' => [
  //         'id' => $data['id']
  //       ],
  //       'set' => [
  //         'name' => $data['name'] . '_update',
  //         'email' => $data['email'] . '_update'
  //       ]
  //     ];
  //   }, $data);

  //   $response = $this
  //     ->withConnection('/postgres/data/update', [
  //       'table' => $this->table,
  //       'modifiers' => $modifiers
  //     ]);

  //   $response
  //     ->assertStatus(201)
  //     ->assertJsonStructure(['message']);

  //   return array_map(function ($data) {
  //     return [
  //       'id' => $data['where']['id'],
  //       'name' => $data['set']['name'],
  //       'email' => $data['set']['email']
  //     ];
  //   }, $modifiers);
  // }

  // /**
  //  * @depends testDataUpdate
  //  */
  // public function testDataUpdated($data)
  // {
  //   $response = $this
  //     ->withConnection('postgres/data/search', [
  //       'table' => $this->table
  //     ]);

  //   $response
  //     ->assertStatus(200)
  //     ->assertJson(['result' => $data]);

  //   return $data;
  // }

  // /**
  //  * @depends testDataUpdated
  //  */
  // public function testDeleteData($data)
  // {
  //   $response = $this
  //     ->withConnection('postgres/data/delete', [
  //       'table' => $this->table,
  //       'modifiers' => $data
  //     ]);

  //   $response
  //     ->assertStatus(201);
  // }

  // public function testDataDeleted()
  // {
  //   $response = $this
  //     ->withConnection('postgres/data/search', [
  //       'table' => $this->table
  //     ]);

  //   $response
  //     ->assertStatus(200)
  //     ->assertJson(['result' => []]);
  // }

  // /**
  //  * @depends testDataDeleted
  //  */
  // public function testDeleteTestTable()
  // {
  //   $response = $this
  //     ->withConnection('postgres/statement', [
  //       'sql' => "drop table if exists $this->table"
  //     ]);

  //   $response
  //     ->assertStatus(201);
  // }
}
