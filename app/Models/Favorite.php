<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_favorites';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'favorite_id';

    protected $fillable = ['user_id', 'game_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }
}
