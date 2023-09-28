<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuditTrailTest extends TestCase
{
    /**
     * test for is audit trail stored during saved.
     *
     * @return void
     */
    public function testAuditTrailIsStoredForSavedEvent(): void
    {
        $response = $this->post(
            '/api/v1/ip/store',
            [
                "ip" => "200.168.100.11",
                "label" => "test"
            ],
            [
                'Service-Id' => 'F67nzek6dbjcnBJqqTri1BWPxX36fpAj',
                'Service-Key' => 'TMbF54aZx8bA9iGjQGQuXrFThu9ZVx4b',
            ]
        );
        $response->assertStatus(201);
        $this->assertDatabaseHas('audit_trails', [
            'event' => 'saved',
            'feature' => 'App\Models\IpAddress',
        ]);
    }


    /**
     * test for is audit trail stored during update.
     *
     * @return void
     */
    public function testAuditTrailIsStoredForUpdateEvent(): void
    {
        $response = $this->post(
            '/api/v1/ip/store',
            [
                "ip" => "200.168.100.11",
                "label" => "test"
            ],
            [
                'Service-Id' => 'F67nzek6dbjcnBJqqTri1BWPxX36fpAj',
                'Service-Key' => 'TMbF54aZx8bA9iGjQGQuXrFThu9ZVx4b',
            ]
        );
        $id = json_decode($response->getContent(), true)['data']['id'];
        $response->assertStatus(201);
        $update_response = $this->patch(
            "/api/v1/ip/update/$id",
            [
                "ip" => "200.168.100.11",
                "label" => "Done"
            ],
            [
                'Service-Id' => 'F67nzek6dbjcnBJqqTri1BWPxX36fpAj',
                'Service-Key' => 'TMbF54aZx8bA9iGjQGQuXrFThu9ZVx4b',
            ]
        );
        $update_response->assertStatus(200);
        $this->assertDatabaseHas('audit_trails', [
            'event' => 'update',
            'feature' => 'App\Models\IpAddress',
        ]);
    }
}
