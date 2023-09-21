<?php

namespace Tests\Feature;

use Tests\TestCase;

class IpUpdateApiTest extends TestCase
{
    /**
     * Test Update IP
     *
     * @return void
     */
    public function testIpUpdateHappyCase(): void
    {
        $response = $this->post(
            '/api/v1/ip/store',
            [
                "ip" => "200.168.100.11",
                "label" => "test"
            ]
        );
        $response->assertStatus(201);
        $id = json_decode($response->getContent(), true)['data']['id'];

        $update_response = $this->patch(
            "/api/v1/ip/update/$id",
            [
                "ip" => "200.168.100.11",
                "label" => "Done"
            ]
        );

        $update_response->assertJsonStructure([
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
        $update_response->assertJson([
            "status" => true,
            "code" => 200,
            "message" => "Ip information updated successfully!",
            "data" => [
                "ip" => "200.168.100.11",
                "label" => "Done",
            ]
        ], false);
    }

    /**
     * Test update IP validation for Ip
     *
     * @return void
     */
    public function testIpUpdateIpValidation(): void
    {
        $response = $this->post(
            '/api/v1/ip/store',
            [
                "ip" => "200.168.100.11",
                "label" => "test"
            ]
        );
        $response->assertStatus(201);
        $id = json_decode($response->getContent(), true)['data']['id'];

        $update_response = $this->patch(
            "/api/v1/ip/update/$id",
            [
                "ip" => "",
                "label" => "Done"
            ]
        );

        $update_response->assertJsonStructure([
            "status",
            "code",
            "message",
            "data" => [
                "ip",
            ]
        ]);
        $update_response->assertJson([
            "status" => false,
            "code" => 400,
            "message" => "Request param validation error.",
            "data" => [
                "ip" => [
                    "The ip field is required."
                ]
            ]
        ], false);
    }


    /**
     * Test update IP validation for label
     *
     * @return void
     */
    public function testIpUpdateLabelValidation(): void
    {
        $response = $this->post(
            '/api/v1/ip/store',
            [
                "ip" => "200.168.100.11",
                "label" => "test"
            ]
        );
        $response->assertStatus(201);
        $id = json_decode($response->getContent(), true)['data']['id'];

        $update_response = $this->patch(
            "/api/v1/ip/update/$id",
            [
                "ip" => "200.168.100.11",
                "label" => ""
            ]
        );

        $update_response->assertJsonStructure([
            "status",
            "code",
            "message",
            "data" => [
                "label",
            ]
        ]);
        $update_response->assertJson([
            "status" => false,
            "code" => 400,
            "message" => "Request param validation error.",
            "data" => [
                "label" => [
                    "The label field is required."
                ]
            ]
        ], false);
    }
}
