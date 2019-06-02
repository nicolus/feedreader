<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testAddFeed()
    {
        $response = $this->actingAs(User::find(1), 'api')->postJson('/api/feeds', [
            "url" => "http:\/\/www.eurosport.fr\/formule-1\/rss_tea2973.xml",
            "type" => 1
        ]);

        $response->assertStatus(200);
    }
}
