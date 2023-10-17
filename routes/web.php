<?php

use App\Models\User;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $posts = []; //initializes the post array to an empty array

    //checks if a user is logged in before getting blogposts
    if(auth()->check()){
        $posts = auth()->user()->userPosts()->latest()->get();
    }
    // $posts = Post::where('user_id', auth()->id())->get();
    return view('home', ['posts' => $posts]);
});

Route::post('/register', [UserController::class, 'register']); //routing registration
Route::post('/logout', [UserController::class, 'logout']); //routing logout
Route::post('/login', [UserController::class, 'login']); //routing login

// SendEmail
Route::post("/sendEmail", [UserController::class, 'sendEmail']);
Route::get("/thank-you", function(){
    
    if(session('name')){
        $name = auth()->user();
        return view('thankyou', ['name' => session('name')]);
    }
    redirect('/');
    }
);

// Blog post related route
Route::post('/create-post', [PostController::class, 'createPost']);
Route::get('/edit-post/{postId}', [PostController::class, 'showEditScreen']);
Route::put('/edit-post/{postId}', [PostController::class, 'updatePost']);
Route::delete('/delete-post/{postId}', [PostController::class, 'deletePost']);