<?php

use App\Events\ChatMessage;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\userController;
use Illuminate\Http\Request;
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
Route::get('/manage-avatar', [userController::class, 'showAvatarForm'])->middleware('auth');
Route::post('/manage-avatar', [userController::class, 'storeAvatar'])->middleware('auth');

//Blog related routes
Route::get('/create-post',[PostController::class, 'showCreateForm'])->middleware('auth');
Route::post('/create-post',[PostController::class, 'storeNewPost'])->middleware('auth');
Route::get('/post/{post}',[PostController::class, 'viewSinglePost']);
Route::get('/search/{term}', [PostController::class, 'search']);

/**  Implementing delete with controller and and routes method.
 * The path is identical to the view single post, same url pattern.
*/
Route::delete('/post/{post}',[PostController::class, 'delete'])->middleware('can:delete,post');

// Routes to view edit form and update
Route::get('post/{post}/edit',[PostController::class, 'showEditForm'])->Middleware('can:update,post');
Route::put('post/{post}', [PostController::class, 'actuallyUpdate'])->middleware('can:update,post');

//Profile related routes
Route::get('/profile/{user:username}', [userController::class, 'profile']);
Route::get('/profile/{user:username}/followers', [userController::class, 'profileFollowers']);
Route::get('/profile/{user:username}/following', [userController::class, 'profileFollowing']);
//Profile URL endpoints
Route::get('/profile/{user:username}/raw', [userController::class, 'profileRaw']);
Route::get('/profile/{user:username}/followers/raw', [userController::class, 'profileFollowersRaw']);
Route::get('/profile/{user:username}/following/raw', [userController::class, 'profileFollowingRaw']);

// Follow related routes
Route::post('/create-follow/{user:username}', [FollowController::class, 'createFollow'])->middleware('auth');
Route::post('/remove-follow/{user:username}', [FollowController::class, 'removeFollow'])->middleware('auth');

// Chat related routes
Route::post('/send-chat-message', function(Request $request){
    // validating text data
    $formFields = $request->validate([
        'textvalue' => 'required'
    ]);

    if (!trim(strip_tags($formFields['textvalue']))) {
        return response()->noContent();
    }

    /**  Broadcasting new instance of our ChatMessage event
     * In the instance we can get data about the user i.e username, avatar
     */
    broadcast(new ChatMessage(
        ['username' =>auth()->user()->username,
        'textvalue' =>strip_tags($request->textvalue),
        'avatar' =>auth()->user()->avatar]
    ))->toOthers();
    return response()->noContent();

})->middleware('auth');


