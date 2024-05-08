<?php

use App\Http\Controllers\exampleController;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;

Route::get('/', [userController::class, "showCorrectHomePage"]);
Route::get('/about', [exampleController::class, "aboutPage"]);

Route::post('/register', [userController::class, "register"]);
Route::post('/login', [userController::class, "login"]);
