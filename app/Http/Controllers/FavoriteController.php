<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FavoriteController extends Controller
{
    public function toggleFavorite($gameId)
    {
        $user = Auth::user();

        if (!$user) {
            Log::warning('⚠️ [FAVORITO] Tentativa sem autenticação', [
                'game_id' => $gameId,
                'ip' => request()->ip()
            ]);
            return response()->json(['message' => 'Usuário não autenticado'], 401);
        }

        Log::info('❤️ [FAVORITO] Toggle favorito', [
            'user_id' => $user->id,
            'username' => $user->name,
            'game_id' => $gameId
        ]);

        try {
            $favorite = Favorite::where('user_id', $user->id)->where('game_id', $gameId)->first();

            if ($favorite) {
                $favorite->delete();
                Log::info('💔 [FAVORITO] Jogo removido dos favoritos', [
                    'user_id' => $user->id,
                    'username' => $user->name,
                    'game_id' => $gameId
                ]);
                return response()->json(['message' => 'Jogo removido dos favoritos']);
            } else {
                Favorite::create([
                    'user_id' => $user->id,
                    'game_id' => $gameId
                ]);
                Log::info('💚 [FAVORITO] Jogo adicionado aos favoritos', [
                    'user_id' => $user->id,
                    'username' => $user->name,
                    'game_id' => $gameId
                ]);
                return response()->json(['message' => 'Jogo adicionado aos favoritos']);
            }
        } catch (\Exception $e) {
            Log::error('❌ [FAVORITO] Erro ao toggle favorito', [
                'user_id' => $user->id,
                'game_id' => $gameId,
                'erro' => $e->getMessage()
            ]);
            return response()->json(['message' => 'Erro ao processar favorito'], 500);
        }
    }
}
