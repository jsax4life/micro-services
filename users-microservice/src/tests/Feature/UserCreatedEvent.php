<?php

namespace Tests\Feature;

use App\Events\UserCreatedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserCreatedEvent extends TestCase
{
    public function testUserCreationAndEventDispatch()
    {
        Event::fake();

        // Create a new user
        $user = User::factory()->create([
            'email' => 'test3@example.com',
            'firstName' => 'John',
            'lastName' => 'Doe',
        ]);

        // Assert that UserCreated event is dispatched
        Event::assertDispatched(UserCreatedNotification::class, function ($event) use ($user) {
            return $event->user->id === $user->id;
        });
    }
}
