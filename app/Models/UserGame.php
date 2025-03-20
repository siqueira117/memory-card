<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGame extends Model
{
        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_user_games';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'user_game_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_id', 'game_id', 'rating', 'status', 'favorite', 'review'];

    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
