<?php

namespace Tests\Feature\Users;

use App\User;
use App\Events\UserCreatedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_stores_valid_user_data()
    {
        $data = [
            'email' => $this->faker->unique()->email,
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
        ];

        $response = $this->postJson('/users', $data);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'message' => 'User created successfully!',
        ]);

        $this->assertDatabaseHas('users', $data);
    }

    public function it_validates_required_fields()
    {
        $data = [];

        $response = $this->postJson('/users', $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'email' => 'The email field is required.',
            'firstName' => 'The first name field is required.',
            'lastName' => 'The last name field is required.',
        ]);
    }

    public function it_dispatches_user_created_event_on_successful_creation()
    {
        $data = [
            'email' => $this->faker->unique()->email,
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
        ];

        $this->expectsEvents(UserCreatedNotification::class);

        $response = $this->postJson('/users', $data);

    }
}
