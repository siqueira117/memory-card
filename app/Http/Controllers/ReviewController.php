<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    /**
     * Exibir reviews de um jogo específico
     */
    public function index(int $gameId)
    {
        $game = Game::findOrFail($gameId);
        
        $reviews = Review::with(['user'])
            ->where('game_id', $gameId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('reviews.index', compact('game', 'reviews'));
    }

    /**
     * Criar um novo review
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Você precisa estar logado para avaliar um jogo.'], 401);
        }

        $validator = Validator::make($request->all(), [
            'game_id' => 'required|exists:tbl_games,game_id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:5000',
            'spoiler' => 'nullable|boolean',
            'played_at' => 'nullable|date',
            'status' => 'nullable|in:playing,completed,dropped,plan_to_play',
            'hours_played' => 'nullable|integer|min:0|max:10000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Verificar se já existe review do usuário para este jogo
            $existingReview = Review::where('user_id', Auth::id())
                ->where('game_id', $request->game_id)
                ->first();

            if ($existingReview) {
                return response()->json([
                    'error' => 'Você já avaliou este jogo. Edite sua avaliação existente.'
                ], 409);
            }

            $review = Review::create([
                'user_id' => Auth::id(),
                'game_id' => $request->game_id,
                'rating' => $request->rating,
                'review' => $request->review,
                'spoiler' => $request->spoiler ?? false,
                'played_at' => $request->played_at,
                'status' => $request->status,
                'hours_played' => $request->hours_played,
            ]);

            Log::info('⭐ [REVIEW] Review criado com sucesso', [
                'review_id' => $review->id,
                'user_id' => Auth::id(),
                'game_id' => $request->game_id,
                'rating' => $request->rating,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Review criado com sucesso!',
                'review' => $review->load('user', 'game'),
            ], 201);

        } catch (\Exception $e) {
            Log::error('❌ [REVIEW] Erro ao criar review', [
                'user_id' => Auth::id(),
                'game_id' => $request->game_id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'error' => 'Erro ao criar review. Tente novamente.'
            ], 500);
        }
    }

    /**
     * Atualizar um review existente
     */
    public function update(Request $request, int $id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Você precisa estar logado.'], 401);
        }

        $review = Review::findOrFail($id);

        // Verificar se o usuário é o dono do review
        if ($review->user_id !== Auth::id()) {
            return response()->json(['error' => 'Você não tem permissão para editar este review.'], 403);
        }

        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:5000',
            'spoiler' => 'nullable|boolean',
            'played_at' => 'nullable|date',
            'status' => 'nullable|in:playing,completed,dropped,plan_to_play',
            'hours_played' => 'nullable|integer|min:0|max:10000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $review->update([
                'rating' => $request->rating,
                'review' => $request->review,
                'spoiler' => $request->spoiler ?? false,
                'played_at' => $request->played_at,
                'status' => $request->status,
                'hours_played' => $request->hours_played,
            ]);

            $review->markAsEdited();

            Log::info('✏️ [REVIEW] Review atualizado', [
                'review_id' => $review->id,
                'user_id' => Auth::id(),
                'rating' => $request->rating,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Review atualizado com sucesso!',
                'review' => $review->fresh()->load('user', 'game'),
            ]);

        } catch (\Exception $e) {
            Log::error('❌ [REVIEW] Erro ao atualizar review', [
                'review_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'error' => 'Erro ao atualizar review. Tente novamente.'
            ], 500);
        }
    }

    /**
     * Deletar um review
     */
    public function destroy(int $id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Você precisa estar logado.'], 401);
        }

        $review = Review::findOrFail($id);

        // Verificar se o usuário é o dono do review ou admin
        if ($review->user_id !== Auth::id() && Auth::user()->type !== 'adm') {
            return response()->json(['error' => 'Você não tem permissão para deletar este review.'], 403);
        }

        try {
            $reviewId = $review->id;
            $gameId = $review->game_id;
            
            $review->delete();

            Log::info('🗑️ [REVIEW] Review deletado', [
                'review_id' => $reviewId,
                'user_id' => Auth::id(),
                'game_id' => $gameId,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Review deletado com sucesso!',
            ]);

        } catch (\Exception $e) {
            Log::error('❌ [REVIEW] Erro ao deletar review', [
                'review_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'error' => 'Erro ao deletar review. Tente novamente.'
            ], 500);
        }
    }

    /**
     * Obter review do usuário para um jogo específico
     */
    public function getUserReview(int $gameId)
    {
        if (!Auth::check()) {
            return response()->json(['review' => null]);
        }

        $review = Review::where('user_id', Auth::id())
            ->where('game_id', $gameId)
            ->with('user')
            ->first();

        return response()->json(['review' => $review]);
    }

    /**
     * Obter estatísticas de reviews de um jogo
     */
    public function getGameStats(int $gameId)
    {
        $game = Game::findOrFail($gameId);

        $stats = [
            'average_rating' => round($game->reviews()->avg('rating'), 1),
            'total_reviews' => $game->reviews()->count(),
            'distribution' => [
                5 => $game->reviews()->where('rating', 5)->count(),
                4 => $game->reviews()->where('rating', 4)->count(),
                3 => $game->reviews()->where('rating', 3)->count(),
                2 => $game->reviews()->where('rating', 2)->count(),
                1 => $game->reviews()->where('rating', 1)->count(),
            ],
        ];

        return response()->json($stats);
    }
}
