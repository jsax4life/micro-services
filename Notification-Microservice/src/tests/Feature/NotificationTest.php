<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use App\Events\UserCreatedNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class NotificationTest extends TestCase
{
    public function testUserCreatedEventHandling()
    {
        Event::fake();

        // Simulate dispatching of UserCreated event
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'firstName' => 'John',
            'lastName' => 'Doe',
        ]);
        event(new UserCreatedNotification($user));

        // Assert that Notification microservice handles the event
        $this->assertTrue(Log::has('User created: test@example.com'));
    }
}
