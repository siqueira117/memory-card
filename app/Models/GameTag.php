<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameTag extends Model
{
    protected $table = 'tbl_game_tags';
    protected $primaryKey = 'game_tag_id';
    
    protected $fillable = [
        'user_id',
        'game_id',
        'tag'
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
