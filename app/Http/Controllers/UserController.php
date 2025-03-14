<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function registerView()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userName' => 'required|min:3|unique:users,name',
            'userEmail' => 'required|email|unique:users,email',
            'userPassword' => 'required|min:6|confirmed'
        ]);
        
        if (!$validator->passes()) {
            return Redirect::back()->withErrors($validator);
        }

        $user = User::create([
            'name' => $request->userName,
            'email' => $request->userEmail,
            'password' => Hash::make($request->userPassword),
        ]);

        Auth::login($user);

        dd($user);
        return redirect()->route('index');
    }

    public function loginView()
    {
        return view('auth.login');
    }

    public function login(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'userName' => 'required|min:3',
            'userPassword' => 'required|min:6'
        ]);
        
        if (!$validator->passes()) {
            return Redirect::back()->withErrors($validator);
        }
        
        if (Auth::attempt(['name' => $request->userName, 'password' => $request->userPassword])) {
            return Redirect::back();
        } else {
            session()->flash('errorMsg', 'E-mail ou senha incorretos.');
            return Redirect::back();
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('index');
    }
}
