<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;


//User related routes
Route::get('/', [userController::class, "showCorrectHomePage"])->name('login');
Route::post('/register', [userController::class, "register"])->middleware('guest');
Route::post('/login', [userController::class, "login"])->middleware('guest');
Route::post('/logout', [userController::class, "logout"])->middleware('auth');

//Blog related routes
Route::get('/create-post',[PostController::class, 'showCreateForm'])->middleware('auth');
Route::post('/create-post',[PostController::class, 'storeNewPost'])->middleware('auth');
Route::get('/post/{post}',[PostController::class, 'viewSinglePost']);


