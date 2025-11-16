<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function registerView()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        Log::info('👤 [REGISTRO] Tentativa de registro', [
            'username' => $request->userName,
            'email' => $request->userEmail,
            'ip' => $request->ip()
        ]);
        
        $validator = Validator::make($request->all(), [
            'userName' => 'required|min:3|unique:users,name',
            'userEmail' => 'required|email|unique:users,email',
            'userPassword' => 'required|min:6|confirmed'
        ]);
        
        if (!$validator->passes()) {
            Log::warning('⚠️ [REGISTRO] Validação falhou', [
                'username' => $request->userName,
                'email' => $request->userEmail,
                'erros' => $validator->errors()->toArray()
            ]);
            return Redirect::back()->withErrors($validator);
        }

        try {
            $user = User::create([
                'name' => $request->userName,
                'email' => $request->userEmail,
                'password' => Hash::make($request->userPassword),
            ]);

            Auth::login($user);
            
            Log::info('🎉 [REGISTRO] Usuário registrado com sucesso', [
                'user_id' => $user->id,
                'username' => $user->name,
                'email' => $user->email
            ]);

            return redirect()->route('index');
        } catch (\Exception $e) {
            Log::error('❌ [REGISTRO] Erro ao registrar usuário', [
                'username' => $request->userName,
                'email' => $request->userEmail,
                'erro' => $e->getMessage(),
                'linha' => $e->getLine()
            ]);
            return Redirect::back()->with('errorMsg', 'Erro ao criar conta. Tente novamente.');
        }
    }

    public function loginView()
    {
        return view('auth.login');
    }

    public function login(Request $request) 
    {
        Log::info('🔐 [LOGIN] Tentativa de login', [
            'username' => $request->userName,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);
        
        $validator = Validator::make($request->all(), [
            'userName' => 'required|min:3',
            'userPassword' => 'required|min:6'
        ]);
        
        if (!$validator->passes()) {
            Log::warning('⚠️ [LOGIN] Validação falhou', [
                'username' => $request->userName,
                'erros' => $validator->errors()->toArray()
            ]);
            return Redirect::back()->withErrors($validator);
        }
        
        if (Auth::attempt(['name' => $request->userName, 'password' => $request->userPassword])) {
            $user = Auth::user();
            Log::info('✅ [LOGIN] Login bem-sucedido', [
                'user_id' => $user->id,
                'username' => $user->name,
                'email' => $user->email,
                'ip' => $request->ip()
            ]);
            return Redirect::back();
        } else {
            Log::warning('❌ [LOGIN] Credenciais inválidas', [
                'username' => $request->userName,
                'ip' => $request->ip()
            ]);
            session()->flash('errorMsg', 'E-mail ou senha incorretos.');
            return Redirect::back();
        }
    }

    public function logout()
    {
        $user = Auth::user();
        
        Log::info('👋 [LOGOUT] Usuário deslogou', [
            'user_id' => $user->id,
            'username' => $user->name,
            'email' => $user->email
        ]);
        
        Auth::logout();
        return redirect()->route('index');
    }

    public function profile()
    {
        $user = Auth::user();
        
        Log::info('👤 [PERFIL] Visualizando perfil', [
            'user_id' => $user->id,
            'username' => $user->name
        ]);
        
        // Get user's games by status (distinct game_id)
        $playedGames = $user->userGames()->where('status', 'played')->with('game')->get();
        $playingGames = $user->userGames()->where('status', 'playing')->with('game')->get();
        $backlogGames = $user->userGames()->where('status', 'backlog')->with('game')->get();
        $wishlistGames = $user->userGames()->where('status', 'wishlist')->with('game')->get();
        
        // Get user's reviews
        $reviews = $user->reviews()->with('game')->latest()->take(5)->get();
        
        // Get user's collections
        $collections = $user->collections()->withCount('games')->orderBy('created_at', 'desc')->get();
        
        // Statistics - count distinct games WITH status (ignore null/empty status)
        $stats = [
            'total_games' => $user->userGames()
                ->whereNotNull('status')
                ->where('status', '!=', '')
                ->distinct('game_id')
                ->count('game_id'),
            'played' => $playedGames->count(),
            'playing' => $playingGames->count(),
            'backlog' => $backlogGames->count(),
            'wishlist' => $wishlistGames->count(),
            'total_reviews' => $user->reviews()->count(),
            'total_collections' => $collections->count(),
        ];
        
        Log::info('📊 [PERFIL] Estatísticas carregadas', [
            'user_id' => $user->id,
            'total_games' => $stats['total_games'],
            'total_reviews' => $stats['total_reviews'],
            'total_collections' => $stats['total_collections']
        ]);
        
        return view('profile', compact('user', 'playedGames', 'playingGames', 'backlogGames', 'wishlistGames', 'reviews', 'collections', 'stats'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('profile-edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        Log::info('✏️ [PERFIL] Atualizando perfil', [
            'user_id' => $user->id,
            'username_atual' => $user->name,
            'username_novo' => $request->name,
            'email_atual' => $user->email,
            'email_novo' => $request->email,
            'tem_avatar' => $request->hasFile('avatar'),
            'alterando_senha' => $request->filled('password')
        ]);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|unique:users,name,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|max:500',
            'password' => 'nullable|min:6|confirmed'
        ]);
        
        if (!$validator->passes()) {
            Log::warning('⚠️ [PERFIL] Validação falhou ao atualizar perfil', [
                'user_id' => $user->id,
                'erros' => $validator->errors()->toArray()
            ]);
            return Redirect::back()->withErrors($validator)->withInput();
        }

        try {
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
                
                Log::info('🖼️ [PERFIL] Avatar atualizado', [
                    'user_id' => $user->id,
                    'avatar_path' => $avatarPath
                ]);
            }
            
            // Update password if provided
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
                Log::info('🔒 [PERFIL] Senha alterada', [
                    'user_id' => $user->id,
                    'username' => $user->name
                ]);
            }
            
            $user->save();
            
            Log::info('✅ [PERFIL] Perfil atualizado com sucesso', [
                'user_id' => $user->id,
                'username' => $user->name,
                'email' => $user->email
            ]);
            
            return Redirect::route('user.profile')->with('success', 'Perfil atualizado com sucesso!');
        } catch (\Exception $e) {
            Log::error('❌ [PERFIL] Erro ao atualizar perfil', [
                'user_id' => $user->id,
                'erro' => $e->getMessage(),
                'linha' => $e->getLine()
            ]);
            return Redirect::back()->with('errorMsg', 'Erro ao atualizar perfil.');
        }
    }
}
