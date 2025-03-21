<?php

namespace App\Models;

use App\Events\GameCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
    protected $fillable = ['game_id', 'name', 'summary', 'storyline', 'slug', 'coverUrl', 'first_release_date', 'total_rating'];

    protected static function booted()
    {
        static::created(function ($game) {
            event(new GameCreated($game));
        });
    }

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

    public function screenshots()
    {
        return $this->hasMany(GameScreeshot::class, 'game_id', 'game_id');
    }

    public function artworks()
    {
        return $this->hasMany(GameArtwork::class, 'game_id', 'game_id');
    }

    public function franchises()
    {
        return $this->belongsToMany(Franchise::class, 'tbl_game_franchises', 'game_id', 'franchise_id');
    }

    public function themes()
    {
        return $this->belongsToMany(Theme::class, 'tbl_game_themes', 'game_id', 'theme_id');
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'tbl_game_companies', 'game_id', 'company_id');
    }

    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'tbl_game_collections', 'game_id', 'collection_id');
    }

    public function manuals()
    {
        return $this->hasMany(GameManual::class, 'game_id', 'game_id');
    }

    public function userGames()
    {
        return $this->hasMany(UserGame::class, 'game_id', 'game_id');
    }

    public function getUserStatus()
    {
        return $this->userGames()->where('user_id', Auth::id())->first();
    }
}
