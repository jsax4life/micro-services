<?php

namespace App\Http\Controllers;

use App\Events\UserCreatedNotification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
// use App\Jobs\ProcessNotification;
use App\Jobs\TestJob;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{
    public function store(Request $request)
    {
        // Define validation rules for incoming data
        $rules = [
            'email' => 'required|email',
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            Log::error('Validation failed: ' . $validator->errors()->toJson());

            return response()->json($validator->errors(), 422);
        }

        // Extract validated data
        $validatedData = $validator->validated();

       

        // Save user data into database
        $user = User::create($validatedData);

         // Log validated data
         Log::info('Validated data: ' . json_encode($validatedData));

        // Dispatch event 
        event(new UserCreatedNotification($user));
        // ProcessNotification::dispatch($user);


        return response()->json(['message' => 'User created successfully'], 201);
    }
}
