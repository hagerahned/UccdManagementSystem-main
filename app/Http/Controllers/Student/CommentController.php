<?php

namespace App\Http\Controllers\Student;

use App\Helpers\ApiResponse;
use App\Helpers\Slug;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\StoreCommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class CommentController extends Controller
{
    public function store(StoreCommentRequest $request)
    {

        // fetch post
        $post = Post::where('slug', $request->post_slug)->first();

        // create slug
        $slug = Str::uuid();
        // create comment
        $comment = $post->comments()->create([
            'content' => $request->content,
            'user_id' => $request->user()->id,
            'post_id' => $post->id,
            'slug' => $slug
        ]);

        return ApiResponse::sendResponse("Comment created successfully", new StoreCommentResource($comment), true);
    }

    public function update(UpdateCommentRequest $request){
        // fetch comment
        $comment = Comment::where('slug', $request->comment_slug)->first();

        // check if comment exists
        if (!$comment) {
            return ApiResponse::sendResponse('Comment not found', [], false);
        }

        // check if comment belongs to user
        if(!$comment->user_id == $request->user()->id){
            return ApiResponse::sendResponse('You are not authorized to update this comment', [], false);
        }

        // update comment
        $comment->update([
            'content' => $request->content
        ]);

        return ApiResponse::sendResponse('Comment updated successfully', new StoreCommentResource($comment), true);
    }

    public function delete(Request $request){
        // validate comment
        $request->validate([
            'comment_slug' =>'required|exists:comments,slug'
        ]);

        // fetch comment
        $comment = Comment::where('slug', $request->comment_slug)->first();

        // check if comment exists
        if (!$comment) {
            return ApiResponse::sendResponse('Comment not found', [], false);
        }

        // check if comment belongs to user
        if(!$comment->user_id == $request->user()->id){
            return ApiResponse::sendResponse('You are not authorized to delete this comment', [], false);
        }

        // delete comment
        $comment->delete();

        return ApiResponse::sendResponse('Comment deleted successfully', [], true);
    }
}
