<?php

namespace App\Http\Controllers;

use App\Models\GameTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameTagController extends Controller
{
    /**
     * Adiciona uma tag a um jogo
     */
    public function store(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:tbl_games,game_id',
            'tag' => 'required|string|max:50',
        ]);

        // Verificar se a tag já existe para este jogo e usuário
        $existingTag = GameTag::where('user_id', Auth::id())
                              ->where('game_id', $request->game_id)
                              ->where('tag', $request->tag)
                              ->first();

        if ($existingTag) {
            return response()->json(['error' => 'Tag já existe'], 400);
        }

        $tag = GameTag::create([
            'user_id' => Auth::id(),
            'game_id' => $request->game_id,
            'tag' => strtolower(trim($request->tag)),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tag adicionada!',
            'tag' => $tag
        ]);
    }

    /**
     * Remove uma tag
     */
    public function destroy($id)
    {
        $tag = GameTag::findOrFail($id);

        // Verificar se é o dono da tag
        if ($tag->user_id !== Auth::id()) {
            return response()->json(['error' => 'Sem permissão'], 403);
        }

        $tag->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tag removida!'
        ]);
    }

    /**
     * Pega todas as tags de um usuário para um jogo específico
     */
    public function getGameTags($gameId)
    {
        $tags = GameTag::where('user_id', Auth::id())
                       ->where('game_id', $gameId)
                       ->get();

        return response()->json($tags);
    }

    /**
     * Pega todas as tags únicas do usuário (para autocomplete)
     */
    public function getUserTags()
    {
        $tags = GameTag::where('user_id', Auth::id())
                       ->select('tag')
                       ->distinct()
                       ->orderBy('tag')
                       ->pluck('tag');

        return response()->json($tags);
    }
}
