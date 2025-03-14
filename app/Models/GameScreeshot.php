<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameScreeshot extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_game_screenshots';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'game_screenshot_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['game_id', 'screenshotUrl'];

    public function game() 
    {
        return $this->hasOne(Game::class);
    }
}
