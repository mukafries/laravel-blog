<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\WelcomeMail;
use PharIo\Manifest\Email;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\SMTP;
use Illuminate\Validation\Rule;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Support\Facades\Mail;


class UserController extends Controller{

    public function logout(){
        auth()->logout();
        return redirect('/');
    }

    public function login(Request $request){
        $incoming_fields = $request->validate([
            'login_name' => ['required'],
            'login_password' => ['required']
        ]);

        if(auth()->attempt([
            'name' => $incoming_fields['login_name'], 
            'password' => $incoming_fields['login_password']]))
        {
            $request->session()->regenerate();
            print("You are now logged in");
        }else{
            print("Log in unsuccessful");
        }

        return redirect('/');
    }


    public function sendEmail(Request $request){

        $incoming_fields = $request->validate([
            'name' => ['required', 'min:3', Rule::unique('users', 'name')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:9', 'max: 100']
        ]);
    
        return redirect('/');
    }

    public function register(Request $request){
        $incoming_fields = $request->validate([
            'name' => ['required', 'min:3', Rule::unique('users', 'name')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:9', 'max: 100']
        ]);

        $incoming_fields['password'] = bcrypt($incoming_fields['password']);

        $user = User::create($incoming_fields);
        Mail::to('blessing201880@outlook.com')->send(new WelcomeMail());

        return redirect('/thank-you')->with('name', $user['name']);
    }
}