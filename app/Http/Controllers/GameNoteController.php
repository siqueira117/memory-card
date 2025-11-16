<?php

namespace App\Http\Controllers;

use App\Models\GameNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameNoteController extends Controller
{
    /**
     * Salva ou atualiza uma nota
     */
    public function store(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:tbl_games,game_id',
            'note' => 'required|string|max:5000',
        ]);

        $note = GameNote::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'game_id' => $request->game_id,
            ],
            [
                'note' => $request->note,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Nota salva com sucesso!',
            'note' => $note
        ]);
    }

    /**
     * Pega a nota de um usuário para um jogo
     */
    public function getGameNote($gameId)
    {
        $note = GameNote::where('user_id', Auth::id())
                        ->where('game_id', $gameId)
                        ->first();

        return response()->json($note);
    }

    /**
     * Deleta uma nota
     */
    public function destroy($gameId)
    {
        $note = GameNote::where('user_id', Auth::id())
                        ->where('game_id', $gameId)
                        ->first();

        if (!$note) {
            return response()->json(['error' => 'Nota não encontrada'], 404);
        }

        $note->delete();

        return response()->json([
            'success' => true,
            'message' => 'Nota deletada!'
        ]);
    }
}
