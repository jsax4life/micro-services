<?php

namespace App\Listeners;

use app\Models\User;
use App\Events\UserCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class UserCreatedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     *
     * @param  UserCreatedNotification  $event
     * @return void
     */
    public function handle(UserCreatedNotification $event)
    {
        try {
            $user = $event->user;

            $logData = [
                'email' => $user->email,
                'firstName' => $user->firstName,
                'lastName' => $user->lastName,
            ];

            file_put_contents(storage_path('app/user_created_log.txt'), json_encode($logData) . PHP_EOL, FILE_APPEND);

            $user = User::create($data);

            Queue::assertPushed(UserCreatedNotification::class, function (UserCreatedNotification $event) use ($user) {
                return $event->user->id === $user->id;
            });
        } catch (\Exception $e) {
            // Log any errors encountered during event handling
            Log::error('Error handling UserCreated event: ' . $e->getMessage());
        }
    }
}
