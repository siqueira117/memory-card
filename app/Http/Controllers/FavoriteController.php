<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggleFavorite($gameId)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Usuário não autenticado'], 401);
        }

        $favorite = Favorite::where('user_id', $user->id)->where('game_id', $gameId)->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['message' => 'Jogo removido dos favoritos']);
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'game_id' => $gameId
            ]);
            return response()->json(['message' => 'Jogo adicionado aos favoritos']);
        }
    }
}
