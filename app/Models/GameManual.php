<?php

namespace App\Models;

use App\Events\ManualCreated;
use Illuminate\Database\Eloquent\Model;

class GameManual extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_game_manuals';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'game_manual_id';

    protected $fillable = ['url', 'game_id', 'platform_id', 'language_id'];

    protected static function booted()
    {
        static::created(function ($manual) {
            event(new ManualCreated($manual));
        });
    }

    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id', 'game_id');
    }

    public function platform()
    {
        return $this->belongsTo(Platform::class, 'platform_id', 'platform_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id', 'language_id');
    }
}
