<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description']; //(One-To-Many) relationship between the Category and Course models.

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
