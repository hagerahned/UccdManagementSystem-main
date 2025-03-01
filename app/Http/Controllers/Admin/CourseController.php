<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ApiResponse;
use App\Helpers\Slug;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Http\Resources\RetriveStudentsResource;
use App\Http\Resources\StoreCourseResource;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class CourseController extends Controller
{

    public function store(StoreCourseRequest $request)
    {
        $slug = Slug::makeCourse(new Course, $request->title);
        $instructor = Instructor::where('email', $request->instructor_email)->first();

        // store course image
        $image = $request->image;
        $extension = $image->getClientOriginalExtension();
        $path = 'public/images/courses/';
        $imageName = $path . uuid_create() . '.' . $extension;
        $newImage = $image->move('images/courses', $imageName);

        if (!$instructor) {
            return ApiResponse::sendResponse('Instructor not found', [],false);
        }
        if ($instructor->course_id != null) {
            return ApiResponse::sendResponse('Instructor already has course', [],true);
        }

        // Create new course
        $course = Course::create([
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'manager_id' => $request->user()->id,
            'image' => $newImage,
            'course_start' => Carbon::parse($request->course_start),
            'course_end' => Carbon::parse($request->course_end),
            'apply_start' => Carbon::parse($request->apply_start),
            'apply_end' => Carbon::parse($request->apply_end),
            'location' => $request->location,
        ]);

        // add instructor to course
        $instructor->update([
            'course_id' => $course->id
        ]);

        return ApiResponse::sendResponse('Course created successfully', new StoreCourseResource($course),true);
    }

    public function update(UpdateCourseRequest $request)
    {
        if (!empty($request)) {
            $course = Course::where('slug', $request->course_slug)->first();
            if (!$course) {
                return ApiResponse::sendResponse('Course not found', [],false);
            }
            $instructor = Instructor::where('email', $request->instructor_email)->first();
            if ($request->hasFile('image')) {
                $image = $request->image;
                $extension = $image->getClientOriginalExtension();
                $path = 'public/images/courses/';
                $imageName = $path . uuid_create() . '.' . $extension;
                $newImage = $image->move('images/courses', $imageName);
            }
            // Create new course
            $course->update([
                'title' => $request->title ?? $course->title,
                'slug' => $request->course_slug,
                'description' => $request->description ?? $course->description,
                'manager_id' => $request->user()->id,
                'image' => $newImage ?? $course->image,
                'course_start' => Carbon::parse($request->course_start) ?? $course->course_start,
                'course_end' => Carbon::parse($request->course_end) ?? $course->course_end,
                'apply_start' => Carbon::parse($request->apply_start) ?? $course->apply_start,
                'apply_end' => Carbon::parse($request->apply_end) ?? $course->apply_end,
                'location' => $request->location ?? $course->location,
            ]);

            // add instructor to course
            $instructor->update([
                'course_id' => $course->id
            ]);

            return ApiResponse::sendResponse('Course updated successfully', new StoreCourseResource($course),true);
        }

        return ApiResponse::sendResponse('No data provided', [],false);
    }

    public function show(Request $request)
    {
        $request->validate([
            'course_slug' => 'required|exists:courses,slug'
        ]);
        $input = $request->course_slug;
        $course = Course::where('slug', $input)->first();
        if (!$course) {
            return ApiResponse::sendResponse('Course not found', [],false);
        }
        return ApiResponse::sendResponse('Course found', new StoreCourseResource($course),true);
    }

    public function delete(request $request)
    {
        $request->validate([
            'course_slug' => 'required|exists:courses,slug'
        ]);
        $input = $request->course_slug;
        $course = Course::where('slug', $input)->first();
        if (!$course) {
            return ApiResponse::sendResponse('Course not found', [],false);
        }
        $course->instructor->course_id = null;
        $course->instructor->save();
        $course->delete();
        return ApiResponse::sendResponse('Course Deleted Successfuly', [],true);
    }

    public function restore(request $request)
    {
        $request->validate([
            'course_slug' => 'required|exists:courses,slug'
        ]);
        $input = $request->course_slug;
        $course = Course::onlyTrashed()->where('slug', $input)->first();
        if (!$course) {
            return ApiResponse::sendResponse('Course not found', [],false);
        }
        $course->restore();
        return ApiResponse::sendResponse('Course restored successfully', [],true);
    }

    public function getAllEnrollmentStudents(Request $request)
    {
        $request->validate([
            'course_slug' => 'required|exists:courses,slug'
        ]);
        $input = $request->course_slug;
        $course = Course::where('slug', $input)->first();
        $students = $course->students;
        if (!$course) {
            return ApiResponse::sendResponse('Course not found', [],false);
        }
        if (!$students) {
            return ApiResponse::sendResponse('No Students Enrolled', [],false);
        }
        return ApiResponse::sendResponse('Student Retrived Successfuly', RetriveStudentsResource::collection($students),true);
    }

    public function acceptStudent(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'course_slug' => 'required|exists:courses,slug'
        ]);

        $user = User::where('email', $request->email)->first();
        $course = Course::where('slug', $request->course_slug)->first();

        if (!$user) {
            return ApiResponse::sendResponse('User not found', [],false);
        }

        if (!$course) {
            return ApiResponse::sendResponse('Course not found', [],false);
        }

        // Check if the student is not enrolled
        $student = $course->students()->where('user_id', $user->id)->first();

        if (!$student) {
            return ApiResponse::sendResponse('Student not enrolled in the course', [],false);
        }

        // Update the pivot status to 'accepted'
        $course->students()->updateExistingPivot($user->id, ['status' => 'accepted']);

        return ApiResponse::sendResponse('Student status updated to accepted', [],true);
    }
}
