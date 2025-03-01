<?php

namespace App\Http\Controllers\Instructor\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\InstructorLoginRequest;
use App\Http\Resources\InstructorLoginResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstructorAuthController extends Controller
{
    public function login(InstructorLoginRequest $request)
    {
        if (Auth::guard('instructor')->attempt($request->only(['email', 'password']))) {
            $user = Auth::guard('instructor')->user();

            $user->token = $user->createToken('instructor', ['instructor'])->plainTextToken;

            return ApiResponse::sendResponse('Login successful', new InstructorLoginResource($user), true);
        }

        // Authentication failed
        return ApiResponse::sendResponse('Invalid credentials', [], false);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return ApiResponse::sendResponse('Logged out successfully', [], true);
    }
}
