<?php
namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Course;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Course $course)
    {
        if (!$course->likes()->where('user_id', auth()->id())->exists()) {
            $course->likes()->create(['user_id' => auth()->id()]);
        }
        return redirect()->back();
    }

    public function destroy(Course $course)
    {
        $course->likes()->where('user_id', auth()->id())->delete();
        return redirect()->back();
    }
}

