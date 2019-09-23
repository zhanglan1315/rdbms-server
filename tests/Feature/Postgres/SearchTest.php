<?php

namespace Tests\Feature\Postgres;

class SearchTest extends BaseCase
{
  protected $table = 'test_insert_table';

  protected function search($params)
  {
    $params['table'] = $this->table;

    return $this->withConnection('postgres/data/search', $params);
  }

  public function testCreateTable()
  { 
    $response = $this
      ->withConnection('postgres/statement', [
        'sql' => "create table if not exists $this->table (
          id serial2,
          name varchar(255),
          email varchar(255),
          salary int
        )"
      ]);

    $response->assertStatus(201);
  }

  /**
   * @depends testCreateTable
   */
  public function testInsertData()
  {
    $data = [];
    for ($i = 0; $i < 10; $i++) {
      $data[] = [
        'name' => 'test_name' . $i,
        'email' => "test_email$i@rdbms.com",
        'salary' => random_int(1, 1000) * 100
      ];
    }

    $response = $this
      ->withConnection('postgres/data/insert', [
        'table' => $this->table,
        'data' => $data
      ]);

    $response->assertStatus(201);
  }

  /**
   * @depends testInsertData
   */
  public function testApiStructure()
  {
    $response = $this->search([
      'page' => 1,
      'perPage' => 100,
      'where' => 'id > 0',
      'sort' => [['id', 'asc'], ['name', 'desc']],
      'columns' => ['id', 'name'],
      'format' => 'connection'
    ]);

    $structure = [
      'data',
      'sql', 'time', 'columns',
      'page', 'total', 'perPage',
    ];
    // dd($response->decodeResponseJson());
    $response
      ->assertStatus(200)
      ->assertJsonStructure($structure);
  }

  /**
   * @depends testApiStructure
   */
  public function testColumnsSort()
  {
    $columns = ['id', 'email', 'salary'];
    $sort = [['salary', 'desc'], ['id', 'desc']];

    $response = $this->search([
      'sort' => $sort,
      'format' => 'table',
      'columns' => $columns,
    ]);

    $result = $response->decodeResponseJson();

    $data = $result['data'];
    $columnsDiff = array_diff(
      array_pluck($result['columns'], 'name'),
      $columns
    );

    $this->assertTrue($columnsDiff === ['ctid']);
  }

  /**
   * @depends testInsertData
   */
  public function testDropTable()
  {
    $response = $this
      ->withConnection('postgres/statement', [
        'sql' => "drop table if exists $this->table"
      ]);

    $response->assertStatus(201);
  }
}
