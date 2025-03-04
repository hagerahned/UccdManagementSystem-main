<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function markAttendance(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        $attendance = Attendance::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'course_id' => $request->course_id,
                'date' => now()->toDateString()
            ],
            ['status' => 1]
        );

        return redirect()->back()->with('success', 'Your attendance has been successfully registered ✅');
    }


    public function showAttendance($course_id)
    {
        $course = Course::findOrFail($course_id);
        $attendances = $course->attendances()->with('user')->get();

        return view('attendance.index', compact('course', 'attendances'));
    }
}
