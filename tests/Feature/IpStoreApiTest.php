<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IpStoreApiTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIpStoreHappyCase(): void
    {
        $response = $this->post(
            '/api/v1/ip/store',
            [
                "ip" => "200.168.100.11",
                "label" => "test"
            ]
        );
        $response->assertStatus(201);
        $response->assertJsonStructure([
            "status",
            "code",
            "message",
            "data" => [
                "ip",
                "label",
                "updated_at",
                "created_at",
                "id"
            ]
        ]);
        $response->assertJson([
            "status" => true,
            "code" => 201,
            "message" => "New ip information created successfully",
            "data" => [
                "ip" => "200.168.100.11",
                "label" => "test",
            ]
        ], false);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIpStoreIpValidation(): void
    {
        $response = $this->post(
            '/api/v1/ip/store',
            [
                "ip" => "",
                "label" => "test"
            ]
        );
        $response->assertStatus(400);
        $response->assertJson([
            "status" => false,
            "code" => 400,
            "message" => "Request param validation error.",
            "data" => [
                "ip" => ["The ip field is required."],
            ]
        ], true);

    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIpStoreLabelValidation(): void
    {
        $response = $this->post(
            '/api/v1/ip/store',
            [
                "ip" => "200.168.100.11",
                "label" => ""
            ]
        );
        $response->assertStatus(400);
        $response->assertJson([
            "status" => false,
            "code" => 400,
            "message" => "Request param validation error.",
            "data" => [
                "label" => ["The label field is required."],
            ]
        ], true);
    }
}
