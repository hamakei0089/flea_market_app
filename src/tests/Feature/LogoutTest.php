<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    /**
     * A basic feature test example.
     */

      /** @test */
    public function user_can_logout_successfully()
    {

    $response = $this->post('/logout');

    $response->assertRedirect('/login');

    }
}
