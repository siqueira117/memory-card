<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_games';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'game_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['game_id', 'name', 'summary', 'storyline', 'slug', 'coverUrl'];

    public function platforms()
    {
        return $this->belongsToMany(Platform::class, 'tbl_game_platforms', 'game_id', 'platform_id');
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'tbl_game_genres', 'game_id', 'genre_id');
    }

    public function roms()
    {
        return $this->hasMany(GameRom::class, 'game_id', 'game_id');
    }

    public function franchises()
    {
        return $this->belongsToMany(Franchise::class, 'tbl_game_franchises', 'game_id', 'franchise_id');
    }
}
