<?php
namespace App\Http\Controllers;

use App\Http\Controllers\LikeController;
use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\Course;

class LikeController extends Controller
{
    public function toggleLike(Request $request)
    {
        $request->validate([
            'likeable_id' => 'required|integer',
            'likeable_type' => 'required|string'
        ]);

        $likeableType = $request->likeable_type === 'course' ? Course::class : Comment::class;
        $likeable = $likeableType::findOrFail($request->likeable_id);

        $existingLike = Like::where('user_id', Auth::id())
            ->where('likeable_id', $likeable->id)
            ->where('likeable_type', $likeableType)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            return response()->json(['message' => 'Like removed'], 200);
        } else {
            Like::create([
                'user_id' => Auth::id(),
                'likeable_id' => $likeable->id,
                'likeable_type' => $likeableType
            ]);
            return response()->json(['message' => 'Liked'], 201);
        }
    }
    Route::middleware(['auth'])->group(function () {
        Route::post('/like', [LikeController::class, 'toggleLike'])->name('like.toggle');
    });
}
