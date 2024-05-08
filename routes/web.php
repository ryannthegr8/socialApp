<?php


use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;

//User related routes
Route::get('/', [userController::class, "showCorrectHomePage"]);
Route::post('/register', [userController::class, "register"]);
Route::post('/login', [userController::class, "login"]);
Route::post('/logout', [userController::class, "logout"]);

