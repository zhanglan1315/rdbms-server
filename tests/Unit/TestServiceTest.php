<?php

namespace Tests\Unit;

use JWT;
use Test;
use Tests\TestCase;

class TestServiceTest extends TestCase
{
  public function testRoot()
  {
    $user = Test::root();
    $this->assertEquals($user->username, 'root');
  }

  public function testToken()
  {
    $token = Test::token();
    $this->assertTrue((boolean)JWT::parse($token));
  }

  public function testWithRoot()
  {
    $response = $this
      ->withRoot()
      ->json('post', '/auth/check');

    $response
      ->assertStatus(200)
      ->assertJsonStructure(['message']);
  }
}
