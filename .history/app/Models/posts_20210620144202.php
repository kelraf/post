<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        "title",
        "message",
        "user_id"
    ]; 

    /**
     * Get the Comments that belongs to a Post.
     */
    public function comments()
    {
        return $this->hasMany(Comments::class, "post_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
