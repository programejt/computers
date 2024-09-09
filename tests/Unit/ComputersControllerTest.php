<?php

namespace Tests\Unit;

use Tests\TestCase;

class ComputersControllerTest extends TestCase
{
  public function setUp(): void {
    parent::setUp();
  }

  public function test_index(): void {
    $response = $this->get(route('home'));
    $response->assertStatus(200);
  }

  public function test_show(): void {
    $response = $this->get(
      route('computer.show', ['id' => 1])
    );

    $response->assertStatus(200);
  }

  public function test_add_computer_as_guest(): void {
    $response = $this->post(
      route('computer.store', ['computer-name' => 'computer name test'])
    );

    $response->assertStatus(302);
    $response->assertRedirectToRoute('login');
  }
}
