<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameGenres extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_game_genres';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'game_genres_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['game_id', 'genre_id'];
}
