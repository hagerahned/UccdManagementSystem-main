<?php

namespace App\Http\Controllers\Student;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\StoreCourseResource;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function enroll(Request $request){
        $request->validate([
            'course_slug' => 'required|exists:courses,slug'
        ]);

        // enroll the student in the course
        $course = Course::where('slug',$request->course_slug)->first();
        // check if course exist
        if (!$course){
            return ApiResponse::sendResponse('course not found',[], false);
        }
        // check if student is already enrolled in the course
        if ($course->students()->where('user_id',$request->user()->id)->exists()){
            return ApiResponse::sendResponse('You are already enrolled in this course',[], false);
        }
        // check if the course enrollment not started
        if($course->apply_start > now()){
            return ApiResponse::sendResponse('Enrollment period has not started yet',[], false);
        }
        // check if enrollment period has ended
        if($course->apply_end < now()){
            return ApiResponse::sendResponse('Enrollment period has ended',[], false);
        }
        
        $course->students()->attach($request->user()->id);
        return ApiResponse::sendResponse('Course enrolled successfully',[], true);
    }

    public function getAllcourses(){
        $courses = Course::where('apply_end','>',now())->get();
        return ApiResponse::sendResponse('Course Retrived successfully', StoreCourseResource::collection($courses), true);
    }
}
