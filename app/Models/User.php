<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Post;
use App\Models\Follow;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * Function for fallback avatar, incase user does not have an avatar.
     *  This function is like a middleman/middle-step for filtering what is going to be the value for avatar.
     */
    protected function avatar(): Attribute {
        return Attribute::make(get: function($value){
            return $value ? '/storage/avatars/' . $value : '/fallback-avatar.jpg';
        });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    /** Used in home posts feed */
    public function feedPosts(){
        /** The parameter below has 6 arguments
         * 1. The model that we want to end up with in this case posts from users being followed.
         * 2. Intermediate table, it has the relationship needed to lookup.
         * 3. Foreign key on the intermediate table.
         * 4. Foreign key on the model we are interested in.
         * 5. Local Key.
         * 6. Local key on the intermediate table.
          */
        return $this->hasManyThrough(
            Post::class,
            Follow::class,
            'user_id',
            'user_id',
            'id',
            'followedUser'
        );
    }

    /** Function below defines relationship between a user and a follower */
    public function followers(){
        return $this->hasMany(Follow::class, 'followedUser');
    }

    /** Function below defines relationship between a user and a following */
    public function followingTheseUsers(){
        return $this->hasMany(Follow::class, 'user_id');
    }

    /** The function below enables querying of posts data from database
     *  Defines relationship between user and posts
     */
    public function posts(){
        return $this->hasMany(Post::class, 'user_id');
    }
}
