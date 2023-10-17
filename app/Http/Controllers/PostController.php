<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    /*
    * @description This method models the incoming postId (a number) into a Post by looking up 
    *        the post with that id in the posts table because the incoming variable name and the parameter name matches
    *
    */
    public function showEditScreen(Post $postId){
        if(auth()->user()->id !== $postId['user_id']){
            return redirect('/');
        }
        return view('edit-post', ['post' => $postId]);
    }

    public function updatePost(Post $postId, Request $request){
        if(auth()->user()->id !== $postId['user_id']){
            return redirect('/');
        }

        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        // clean inputted data
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        $postId->update($incomingFields);
        return redirect('/');

    }

    public function deletePost(Post $postId){
        if(auth()->user()->id === $postId['user_id']){
            $postId->delete();
        }

        return redirect('/');
        
    }


    public function createPost(Request $request){
        $incomingFields = $request->validate([
            'title' => ['required'],
            'body' => ['required']
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();

        Post::create($incomingFields);
        return redirect('/');
    }
}
