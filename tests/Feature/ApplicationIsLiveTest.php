<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApplicationIsLiveTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testWelcomePage()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertExactJson([
            "status" => true,
            "code" => 200,
            "message" => "Ad group IP management is live",
            "data" => []
        ]);
    }
}
