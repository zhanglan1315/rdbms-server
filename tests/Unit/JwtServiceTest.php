<?php

namespace Tests\Unit;

use DB;
use JWT;
use Tests\TestCase;

class JwtServiceTest extends TestCase
{
  private function createUser()
  {
    return (object) [
      'id' => 1,
      'name' => 'foo',
      'email' => 'bar',
      'roles' => [
        1, 3, 4, 2
      ]
    ];
  }

  public function testGenerate()
  {
    $tokenInfo = JWT::generate($this->createUser());

    $this->assertTrue(is_array($tokenInfo));

    return $tokenInfo;
  }

  /**
   * @depends testGenerate
   */

  public function testParse($tokenInfo)
  {
    JWT::parse($tokenInfo['token']);

    $this->assertEquals($this->createUser(), JWT::tokenData());
  }
}
