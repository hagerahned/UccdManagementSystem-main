<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'courses';
    protected $guarded = [];

    public function manager(){
        return $this->belongsTo(Manager::class);
    }
    public function instructor(){
        return $this->hasOne(Instructor::class);
    }

    public function students(){
        return $this->belongsToMany(User::class,'course_user')->withPivot('status')->withTimestamps();
    }
     
    protected $fillable = ['name', 'description', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}


