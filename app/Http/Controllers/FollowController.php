<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function createFollow(User $user){
        // You cannot follow yourself
        if ($user->id == auth()->user()->id) {
            return back()->with('failed', 'you cannot follow yourself');
        }

        // You cannot follow someone you are already following
        $existCheck = Follow::where([
            ['user_id', '=', auth()->user()->id],
            ['followedUser', '=', $user->id]
    ])->count();

        if ($existCheck) {
            return back()->with('failed', 'You already follow that user');
        }

        // follow
        $newFollow = new Follow;
        $newFollow->user_id = auth()->user()->id;
        $newFollow->followedUser = $user->id;
        $newFollow->save();

        return back()->with('Success', 'Successfully followed');

    }

    public function removeFollow(){

    }
}
