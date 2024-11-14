<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;


class RegisterController extends Controller
{
    /** @return JsonResponse The JSON response indicating the result of the login attempt.*/
    public function register(RegisterRequest $request): JsonResponse
    {
        // Attempt to log the user in
        // if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        //     // Authentication passed
        //     return response()->json(['success' => true, 'message' => 'Login successful!', 'redirect_url' => route('dashboard')]);
        // }

        // Authentication failed
        return response()->json(['success' => false, 'message' => 'Invalid email or password.' ], 401);
    }
}
