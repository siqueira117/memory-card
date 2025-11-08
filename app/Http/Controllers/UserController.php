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

    public function profile()
    {
        $user = Auth::user();
        
        // Get user's games by status
        $playedGames = $user->userGames()->where('status', 'played')->with('game')->get();
        $playingGames = $user->userGames()->where('status', 'playing')->with('game')->get();
        $backlogGames = $user->userGames()->where('status', 'backlog')->with('game')->get();
        $wishlistGames = $user->userGames()->where('status', 'wishlist')->with('game')->get();
        
        // Get user's reviews
        $reviews = $user->reviews()->with('game')->latest()->take(5)->get();
        
        // Statistics
        $stats = [
            'total_games' => $user->userGames()->count(),
            'played' => $playedGames->count(),
            'playing' => $playingGames->count(),
            'backlog' => $backlogGames->count(),
            'wishlist' => $wishlistGames->count(),
            'total_reviews' => $user->reviews()->count(),
        ];
        
        return view('profile', compact('user', 'playedGames', 'playingGames', 'backlogGames', 'wishlistGames', 'reviews', 'stats'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('profile-edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|unique:users,name,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|max:500',
            'password' => 'nullable|min:6|confirmed'
        ]);
        
        if (!$validator->passes()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // Update basic info
        $user->name = $request->name;
        $user->email = $request->email;
        $user->bio = $request->bio;
        
        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && file_exists(storage_path('app/public/' . $user->avatar))) {
                unlink(storage_path('app/public/' . $user->avatar));
            }
            
            // Store new avatar
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }
        
        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();
        
        return Redirect::route('user.profile')->with('success', 'Perfil atualizado com sucesso!');
    }
}
