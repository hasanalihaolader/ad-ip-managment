<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApplicationIsLiveTest extends TestCase
{
    /**
     * Simple test for is application live or not.
     *
     * @return void
     */
    public function testWelcomePage(): void
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
