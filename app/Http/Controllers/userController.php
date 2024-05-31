<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class userController extends Controller
{
    public function storeAvatar(Request $request){
        // uploaded file server-side validation
        $request->validate([
            'avatar' => 'required|image|max:20000'
        ]);
        /** Method 1 without compressing
         *  1. Get data from input form
         *  2. The input tag from form has a name of "avatar" that is why it is used below
         *  3. the file is stored in a folder named as "userAvatars"
         *  4. the folder is created in storage/app/userAvatars
        */
        // $request->file('avatar')->store('public/userAvatars');

        /** Method 2 with compressing
         *  1. create a variable with an new instance of ImageManager
         *  ImageManager class comes from the composer package intervention/image
         *  A driver is also used
        */
            // user variable
            $user = auth()->user();
            // variable for creating random filename
            $filename = $user->id . "_" . uniqid() . ".jpg";

            $manager = new ImageManager(new Driver());
            // Give received file to manager
            $image = $manager->read($request->file('avatar'));
            // resizing
            $imgData = $image->cover(120, 120)->toJpeg();
            // store to laravel
            Storage::put("public/avatars/" . $filename , $imgData);
            // Variable to enable deleting avatar
            $oldAvatar = $user->avatar;
            // store to database
            $user->avatar = $filename;
            $user->save();
            // Deleting old avatar incase the user updates their avatar
            if ($oldAvatar != '/fallback-avatar.jpg') {
                Storage::delete(str_replace("/storage/", "public/", $oldAvatar));
            }
            return back()->with('Success', 'Congrats on your new avatar');
    }
    public function showAvatarForm(){
        return view('avatar-form');
    }

    // Profiles Shared function
    private function getSharedData($user){
        // Follow and Unfollow button
        $currentlyFollowing = 0; /** Default for even when user is not logged in */

        if (auth()->check()) {
            $currentlyFollowing = Follow::where([
                ['user_id', '=', auth()->user()->id],
                ['followedUser', '=', $user->id]
            ])->count();
        }

        View::share('sharedData', [
            'currentlyFollowing' => $currentlyFollowing,
            'avatar' => $user->avatar ,
            'username'=> $user->username,
            'postCount' => $user->posts()->count(),
            'followerCount' => $user->followers()->count(),
            'followingCount' => $user->followingTheseUsers()->count()
        ]);
    }

    // function for viewing profile
    public function profile(User $user){
        // importing shared function
        $this->getSharedData($user);
        //Querying the username, posts and postCount from database
        return view('profile-posts', [
            'posts' => $user->posts()->latest()->get(),
        ]);
    }
    // function for viewing followers in profile
    public function profileFollowers(User $user){
        // importing shared function
        $this->getSharedData($user);
        //Querying the username, posts and postCount from database
        return view('profile-followers', [
            'followers' => $user->followers()->latest()->get(),
        ]);
    }
    // function for viewing those following
    public function profileFollowing(User $user){
       // importing shared function
       $this->getSharedData($user);
       //Querying the username, posts and postCount from database
       return view('profile-following', [
           'following' => $user->followingTheseUsers()->latest()->get(),
       ]);
    }
    public function logout(){
        auth()->logout();
        return redirect('/')->with('Success', 'You have successfully logged out.');
    }
    public function showCorrectHomePage(){
        if (auth()->check()) {
            return view('homepage-feed');
        } else {
            return view('homepage');
        }

    }
    public function login(Request $request) {
        $incomingFields = $request -> validate([
            'loginusername' => 'required',
            'loginpassword' => 'required'
        ]);

        //Checks if the user has an account
        if (Auth()->attempt([
            'username'=>$incomingFields['loginusername'],
            'password'=>$incomingFields['loginpassword']
        ])) {

            //Logs the user in
            $request->session()->regenerate();
            return redirect('/')->with('Success', 'You have successfully logged in.');
        } else {
            return redirect('/')->with('failed', 'Invalid username or password.');
        }

    }
    public function register(Request $request){
        $incomingFields = $request->validate([
            'username' => ['required','min:3', 'max:20', Rule::unique('users', 'username')],
            'email' => ['required', 'email', Rule::unique('users', 'email') ],
            'password' => ['required', 'min:6','confirmed'],
        ]);

        $incomingFields['password'] = bcrypt($incomingFields['password']);

        //Login the new user automatically
        $user = User::create($incomingFields);
        auth()->login($user);


        return redirect('/')->with('Success', 'Thank you for creating an account.');
    }
}
