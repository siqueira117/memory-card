<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameArtwork extends Model
{
         /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_game_artworks';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'game_artwork_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['game_id', 'artworkUrl'];

    public function game() 
    {
        return $this->hasOne(Game::class);
    }
}
