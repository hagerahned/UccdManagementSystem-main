<?php
namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Course;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Course $course)
    {
        $like = Like::where('course_id', $course->id)->where('user_id', auth()->id())->first();

        if ($like) {
            $like->delete();
            return back()->with('success', 'Like removed.');
        } else {
            Like::create([
                'course_id' => $course->id,
                'user_id' => auth()->id(),
            ]);
            return back()->with('success', 'Liked!');
        }
    }
}
