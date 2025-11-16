<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'game_id',
        'rating',
        'review',
        'spoiler',
        'played_at',
        'status',
        'hours_played',
        'is_edited',
        'edited_at',
    ];

    protected $casts = [
        'spoiler' => 'boolean',
        'is_edited' => 'boolean',
        'played_at' => 'datetime',
        'edited_at' => 'datetime',
        'rating' => 'integer',
        'hours_played' => 'integer',
    ];

    /**
     * Relacionamento com User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento com Game
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class, 'game_id', 'game_id');
    }

    /**
     * Scope para filtrar por rating
     */
    public function scopeByRating($query, int $rating)
    {
        return $query->where('rating', $rating);
    }

    /**
     * Scope para filtrar por jogo
     */
    public function scopeByGame($query, int $gameId)
    {
        return $query->where('game_id', $gameId);
    }

    /**
     * Scope para filtrar por usuário
     */
    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope para reviews recentes
     */
    public function scopeRecent($query, int $limit = 10)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }

    /**
     * Retorna as estrelas em formato array para facilitar renderização
     */
    public function getStarsAttribute(): array
    {
        return [
            'filled' => $this->rating,
            'empty' => 5 - $this->rating
        ];
    }

    /**
     * Retorna o status formatado
     */
    public function getStatusLabelAttribute(): ?string
    {
        return match($this->status) {
            'playing' => '🎮 Jogando',
            'completed' => '✅ Completado',
            'dropped' => '⏸️ Pausado',
            'plan_to_play' => '📋 Quero Jogar',
            default => null,
        };
    }

    /**
     * Verifica se o review foi editado
     */
    public function wasEdited(): bool
    {
        return $this->is_edited && $this->edited_at !== null;
    }

    /**
     * Marca o review como editado
     */
    public function markAsEdited(): void
    {
        $this->update([
            'is_edited' => true,
            'edited_at' => now(),
        ]);
    }
}
