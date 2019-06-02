<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testApiRequiresAuthentication()
    {
        $response = $this->getJson('/api/feeds');

        $response->assertStatus(401);
    }
}
