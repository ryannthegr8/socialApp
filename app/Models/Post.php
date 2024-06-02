<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    //Search
    use Searchable;

    use HasFactory;

    // For data being involved when a post is made
    protected $fillable = ['title', 'body', 'user_id'];

    //Search function
    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
        ];
    }

    //For displaying user who made the post
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
