<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        // Attempt to log the user in
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Authentication passed
            return response()->json(['success' => true, 'message' => 'Login successful!', 'redirect_url' => route('dashboard')]);
        }

        // Authentication failed
        return response()->json(['success' => false, 'message' => 'Invalid email or password.' ], 401);
    }
}
