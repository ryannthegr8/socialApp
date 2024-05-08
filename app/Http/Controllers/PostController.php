<?php

namespace App\Http\Controllers;

use App\Models\post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function viewSinglePost(Post $post){
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

        Post::create($incomingFields);

        return'jhgjygjh';

    }
    public function showCreateForm(){
        return view('create-post');
    }
}
