<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Follow extends Model
{
    use HasFactory;

    /** The functions below enable the follow model to have every information about a user i.e avatar, username..
     * Initially the model only had the Id of the users without other information about the users.
     */
    public function userDoingTheFollowing(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function userBeingFollowed(){
        return $this->belongsTo(User::class, 'followedUser');
    }
}
