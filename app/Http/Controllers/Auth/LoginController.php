<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    /** @return JsonResponse The JSON response indicating the result of the login attempt.*/
    public function login(LoginRequest $request): JsonResponse
    {
        // Attempt to log the user in
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Authentication passed
            if(Auth::user()->is_admin){
                return response()->json(['success' => true, 'message' => 'Login successful!', 'redirect_url' => route('admin.dashboard')]);
            }else{
                return response()->json(['success' => true, 'message' => 'Login successful!', 'redirect_url' => route('dashboard')]);
            }
        }

        // Authentication failed
        return response()->json(['success' => false, 'message' => 'Invalid email or password.' ], 401);
    }

    public function logout(){
        Auth::logout(); // Log the user out
        return redirect('/'); 
    }
}
