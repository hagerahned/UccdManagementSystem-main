<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ManagerLoginRequest;
use App\Http\Resources\ManagerLoginResource;
use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerAuthController extends Controller
{
    public function login(ManagerLoginRequest $request)
    {
        if (Auth::guard('manager')->attempt($request->only(['email', 'password']))) {
            $user = Auth::guard('manager')->user();

            $user->token = $user->createToken('manager', ['manager'])->plainTextToken;

            return ApiResponse::sendResponse('Login successful', new ManagerLoginResource($user),true);
        }

        // Authentication failed
        return ApiResponse::sendResponse('Invalid credentials',[],false);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return ApiResponse::sendResponse('Logged out successfully', [],true);
    }
}
