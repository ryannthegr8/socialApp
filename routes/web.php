<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;

// Admin pages
Route::get('/admin-only', function(){
    return 'Only admins can see this page';
})->middleware('can:visitAdminPages');

//User related routes
Route::get('/', [userController::class, "showCorrectHomePage"])->name('login');
Route::post('/register', [userController::class, "register"])->middleware('guest');
Route::post('/login', [userController::class, "login"])->middleware('guest');
Route::post('/logout', [userController::class, "logout"])->middleware('auth');
Route::get('/manage-avatar', [userController::class, 'showAvatarForm']);
Route::post('/manage-avatar', [userController::class, 'storeAvatar']);

//Blog related routes
Route::get('/create-post',[PostController::class, 'showCreateForm'])->middleware('auth');
Route::post('/create-post',[PostController::class, 'storeNewPost'])->middleware('auth');
Route::get('/post/{post}',[PostController::class, 'viewSinglePost']);

/**  Implementing delete with controller and and routes method.
 * The path is identical to the view single post, same url pattern.
*/
Route::delete('/post/{post}',[PostController::class, 'delete'])->middleware('can:delete,post');

// Routes to view edit form and update
Route::get('post/{post}/edit',[PostController::class, 'showEditForm'])->Middleware('can:update,post');
Route::put('post/{post}', [PostController::class, 'actuallyUpdate'])->middleware('can:update,post');

//Profile related routes
Route::get('/profile/{user:username}', [userController::class, 'profile']);


