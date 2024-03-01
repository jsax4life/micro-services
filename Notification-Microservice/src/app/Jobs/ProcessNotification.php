<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        // Save data to log file
        $logData = [
            'email' => '',
            'firstName' => '',
            'lastName' => ''
        ];

        file_put_contents(storage_path('app/notification_log.txt'), json_encode($logData) . PHP_EOL, FILE_APPEND);
    }
}
