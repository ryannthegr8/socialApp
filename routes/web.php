<?php

use App\Http\Controllers\exampleController;
use Illuminate\Support\Facades\Route;

Route::get('/', [exampleController::class, "homePage"]);
Route::get('/about', [exampleController::class, "aboutPage"]);
