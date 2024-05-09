<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;


//User related routes
Route::get('/', [userController::class, "showCorrectHomePage"]);
Route::post('/register', [userController::class, "register"]);
Route::post('/login', [userController::class, "login"]);
Route::post('/logout', [userController::class, "logout"]);

//Blog related routes
Route::get('/create-post',[PostController::class, 'showCreateForm']);
Route::post('/create-post',[PostController::class, 'storeNewPost']);
Route::get('/post/{post}',[PostController::class, 'viewSinglePost']);


