<?php

namespace Tests\Feature\Postgres;

class SchemaTest extends BaseCase
{
  public function testSearchSchemas()
  {
    $response = $this
      ->withConnection('postgres/schema/search');

    $response
      ->assertStatus(200)
      ->assertJsonStructure([]);
  }

  public function testCreateSchema()
  {
    $schema = 'test_schema';

    $response = $this
      ->withConnection('postgres/schema/create', [
        'name' => $schema
      ]);

    $response
      ->assertStatus(201)
      ->assertJsonStructure(['message']);

    return $schema;
  }

  /**
   * @depends testCreateSchema
   */
  public function testSchemaCreated($schema)
  {
    $response = $this
      ->withConnection('postgres/schema/search');

    $response
      ->assertJsonFragment([$schema]);
  }

  /**
   * @depends testCreateSchema
   */
  public function testRenameSchema($schema)
  {
    $rename = 'test_schema_rename';

    $response = $this
      ->withConnection('postgres/schema/rename', [
        'name' => $schema,
        'rename' => $rename
      ]);

    $response
      ->assertStatus(201)
      ->assertJsonStructure(['message']);

    return $rename;
  }

  /**
   * @depends testRenameSchema
   */
  public function testSchemaRenamed($schema)
  {
    $response = $this
      ->withConnection('postgres/schema/search');

    $response
      ->assertJsonFragment([$schema]);
  }

  /**
   * @depends testRenameSchema
   */
  public function testSchemaDelete($schema)
  {
    $response = $this
      ->withConnection('postgres/schema/delete', [
        'name' => $schema
      ]);

    $response
      ->assertStatus(201)
      ->assertJsonStructure(['message']);

    return $schema;
  }

  /**
   * @depends testSchemaDelete
   */
  public function testSchemaDeleted($schema)
  {
    $response = $this
      ->withConnection('postgres/schema/search');

    $response
      ->assertStatus(200)
      ->assertJsonMissingExact([$schema]);
  }
}
