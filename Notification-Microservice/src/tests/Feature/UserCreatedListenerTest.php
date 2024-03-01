<?php

namespace Tests\Unit\Listeners;

use App\Models\User;
use App\Events\UserCreationNotification;
use App\Listeners\UserCreatedListener;
use Illuminate\Foundation\Testing\FakeStorage;
use Tests\TestCase;

class UserCreatedListenerTest extends TestCase
{
    use FakeStorage;

    public function setUp(): void
    {
        parent::setUp();
        $this->disk = $this->fakeStorage();
    }

    /** @test */
    public function it_handles_user_created_event_and_writes_data_to_log()
    {
        $user = new User([
            'email' => 'test@example.com',
            'firstName' => 'John',
            'lastName' => 'Doe',
        ]);

        $event = new UserCreatedNotification($user);

        // Instantiate the listener
        $listener = new UserCreatedListener($this->disk);

        // Call the handle method to process the event
        $listener->handle($event);

        $this->assertFileExists($this->disk->path('user_creation.log'));
        $this->disk->assertExists('user_creation.log'); // Alternative assertion using FakeStorage

        $logContents = $this->disk->get('user_creation.log');
        $this->assertStringContainsString($user->email, $logContents);
        $this->assertStringContainsString($user->firstName, $logContents);
        $this->assertStringContainsString($user->lastName, $logContents);
    }
}
