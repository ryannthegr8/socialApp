<?php

namespace App\Http\Controllers;

use App\Mail\NewPostEmail;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller
{
    public function search($term){
        $posts = Post::search($term)->get();
        // To get more search data about users
        $posts->load('user:id, username, avatar');

        return $posts;
    }
    /** Parameter requirements: Post type-hinting and Incoming request */
    public function actuallyUpdate(Post $post, Request $request){
        // validating the request
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        // Stripping out any HTML tags that might be in the values
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        /** Making changes/ Updating the database
         * 1. Using the instance of post, call update method
         * 2. Give it the values you wanna replace with in parameters
         */
        $post->update($incomingFields);

        /**  Return user to same post after updating
         * back - Takes user to url they came from previously
         */
        return back()->with('Success', 'Post successfully updated');

    }

    /** 1. Getting access to the already existing data in the database using "Post $post"
     *  2. return the edit page with the data from the database using associative array
     */
    public function showEditForm(Post $post){
        return view('edit-post', ['post' => $post]);

    }
    /** Implementing delete with controller and routes method */
    public function delete(Post $post){

       /**  The function below is another method of allowing only the user to delete posts
        *
           * if (auth()->user()->cannot('delete', $post)) {
           * return 'You cannot do that';
           *}
        */
        $post->delete();

        return redirect('/profile/'. auth()->user()->username)->with('Success'. 'Post Successfully Deleted');
    }
    public function viewSinglePost(Post $post){
        //Markdown
        $post['body'] = Str::markdown($post->body);

        return view('single-post', ['post' => $post]);
    }
    public function storeNewPost(Request $request){
        // Validating the request
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        // stripping out any HTML tags that might be in the values
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();

        $newPost = Post::create($incomingFields);

        // Mail
        Mail::to(auth()->user()->email)->send(new NewPostEmail([
            'name' => auth()->user()->username,
            'title' => $newPost->title,

        ]));

        return redirect("post/{$newPost->id}")->with('Success', 'New post successfully created.');

    }
    public function showCreateForm(){
        return view('create-post');
    }
}
