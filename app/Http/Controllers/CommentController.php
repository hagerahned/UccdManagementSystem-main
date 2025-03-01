<?php
namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Course;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $course->comments()->create([
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Comment added successfully!');
    }
}
