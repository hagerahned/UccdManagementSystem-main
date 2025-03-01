<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInstructorRequest;
use App\Http\Requests\UpdateInstructorRequest;
use App\Http\Resources\InstructorResource;
use App\Http\Resources\StoreInstructorResource;
use App\Http\Traits\SlugUsername;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Helpers\Slug;
use Illuminate\Support\Facades\Auth;

class InstructorController extends Controller
{

    public function store(StoreInstructorRequest $request)
    {
        $username = Slug::makeUser(new Instructor(), $request->name);
        $instructor = Instructor::create([
            'name' => $request->name,
            'username' => $username,
            'email' => $request->email,
            'password' =>  bcrypt($request->password),
            'phone' => $request->phone,
            'description' => $request->description,
            'manager_id' => $request->user()->id,
        ]);
        return ApiResponse::sendResponse('instructor created successfully', new StoreInstructorResource($instructor),true);
    }

    public function show(Request $request)
    {
        $input = $request->username;
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            $instructor = Instructor::where('email', $input)->first();
        } else {
            $instructor = Instructor::where('username', $input)->first();
        }

        if ($instructor) {
            return ApiResponse::sendResponse('instructor created successfully', new InstructorResource($instructor),true);
        } else {
            return ApiResponse::sendResponse('instructor not found', [],false);
        }
    }

    public function update(UpdateInstructorRequest $request)
    {
        if ($request->has('email')) {
            $instructor = Instructor::where('email', $request->email)->first();
            if (!$instructor) {
                $instructor = Instructor::where('username', $request->username)->first();
            }
        }

        $instructor->update([
            'name' => $request->name ?? $instructor->name,
            'email' => $request->email ?? $instructor->email,
            'username' => $request->username ?? $instructor->username,
            'phone' => $request->phone ?? $instructor->phone,
            'description' => $request->description ?? $instructor->description,
            'password' => bcrypt($request->password) ?? $instructor->password,
        ]);

        return ApiResponse::sendResponse('instructor updated successfully', new StoreInstructorResource($instructor),true);
    }

    public function delete(Request $request)
    {
        $input = $request->username;
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            $instructor = Instructor::where('email', $input)->first();
        } else {
            $instructor = Instructor::where('username', $input)->first();
        }

        if ($instructor) {
            $instructor->tokens()->delete();
            $instructor->delete();
            return ApiResponse::sendResponse('instructor deleted successfully', [],true);
        } else {
            return ApiResponse::sendResponse('instructor not found', [],false);
        }
    }

    public function restore(Request $request)
    {
        $input = $request->username;
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            $instructor = Instructor::onlyTrashed()->where('email', $input)->first();
        } else {
            $instructor = Instructor::onlyTrashed()->where('username', $input)->first();
        }

        if ($instructor) {
            $instructor->restore();
            return ApiResponse::sendResponse('instructor restored successfully', [],true);
        } else {
            return ApiResponse::sendResponse('instructor not found', [],false);
        }
    }
}
