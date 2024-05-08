<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class userController extends Controller
{
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
            return 'Logged in';
        } else {
            return 'Wrong username or password';
        }

    }
    public function register(Request $request){
        $incomingFields = $request->validate([
            'username' => ['required','min:3', 'max:20', Rule::unique('users', 'username')],
            'email' => ['required', 'email', Rule::unique('users', 'email') ],
            'password' => ['required', 'min:6','confirmed'],
        ]);

        $incomingFields['password'] = bcrypt($incomingFields['password']);

        User::create($incomingFields);
        return 'Hello from register';
    }
}
