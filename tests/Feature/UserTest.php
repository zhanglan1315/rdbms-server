<?php

namespace Tests\Feature;

use JWT;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
  public function testCreate()
  {
    $response = $this
      ->post('/users', [
        'username' => 'testCreateUser',
        'password' => '123456',
        'email' => 'tester@system.com'
      ]);

    $response
      ->assertStatus(201)
      ->assertJsonStructure(['message', 'id']);

    return $response->decodeResponseJson()['id'];
  }

  public function testLogin()
  {
    $response = $this
      ->post('/auth/login', [
        'username' => 'testCreateUser',
        'password' => '123456'
      ]);

    $response
      ->assertStatus(201)
      ->assertJsonStructure([
        'token', 'expired_at', 'refresh_at'
      ]);

    return $response->decodeResponseJson()['token'];
  }

  /**
   * @depends testLogin
   */
  public function testDelete($token)
  {
    $response = $this
      ->withHeaders(['Authorization' => $token])
      ->post('/users/delete');

    $response
      ->assertStatus(201)
      ->assertJsonStructure(['message']);
  }
}
