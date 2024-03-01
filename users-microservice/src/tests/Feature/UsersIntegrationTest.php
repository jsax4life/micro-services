<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersIntegrationTest extends TestCase
{
    /**
     */
    public function testStoreWithValidData()
    {
        $data = [
            'email' => 'test1@example.com',
            'firstName' => 'John',
            'lastName' => 'Doe',
        ];
        $response = $this->postJson('/api/users', $data);
        $response->assertStatus(201);
    }

    /**
     * Test store method with invalid data.
     *
     * @return void
     */
    public function testStoreWithInvalidData()
    {
        $data = [
            // Missing 'email' field
            'firstName' => 'John',
            'lastName' => 'Doe',
        ];
        $response = $this->postJson('/api/users', $data);
        $response->assertStatus(422);
    }
}
