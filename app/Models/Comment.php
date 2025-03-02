<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Comment extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = ['course_id', 'user_id', 'content', 'comment'];

    protected $guarded = [];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
