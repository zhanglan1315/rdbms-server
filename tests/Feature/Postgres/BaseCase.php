<?php

namespace Tests\Feature\Postgres;

use Test;
use Tests\TestCase;

class BaseCase extends TestCase
{
  protected $schema;

  protected $database;

  protected function schema($schema)
  {
    $this->schema = $schema;
  
    return $this;
  }

  protected function database($database)
  {
    $this->database = $database;

    return $this;
  }

  protected function withConnection($url, $data = [])
  {
    $data['connection_id'] = Test::postgresConnection()->id;
    $data['schema'] = $this->schema;
    $data['database'] = $this->database;

    return $this
      ->withRoot()
      ->post($url, $data);
  }
}
