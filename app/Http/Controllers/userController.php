<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class userController extends Controller
{

    public function profile(User $user){
        return view('profile-posts', ['username'=> $user->username, 'posts' => $user->posts()->latest()->get(), 'postCount' => $user->posts()->count()]);
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
        if (Auth()->attempt(['username'=>$incomingFields['loginusername'], 'password'=>$incomingFields['loginpassword']])) {

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
