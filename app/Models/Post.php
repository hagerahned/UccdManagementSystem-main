<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $table = 'posts';
    protected $guarded = [];

    public function manager(){
        return $this->belongsTo(Manager::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
