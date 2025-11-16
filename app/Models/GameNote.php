<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameNote extends Model
{
    protected $table = 'tbl_game_notes';
    protected $primaryKey = 'game_note_id';
    
    protected $fillable = [
        'user_id',
        'game_id',
        'note'
    ];

    /**
     * Relacionamento com usuário
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Relacionamento com jogo
     */
    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id', 'game_id');
    }
}
