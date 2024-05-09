<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function viewSinglePost(Post $post){
        //Markdown
        $post['body'] = Str::markdown($post->body);

        return view('single-post', ['post' => $post]);
    }
    public function storeNewPost(Request $request){
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();

        $newPost = Post::create($incomingFields);

        return redirect("post/{$newPost->id}")->with('Success', 'New post successfully created.');

    }
    public function showCreateForm(){
        return view('create-post');
    }
}
