<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameRom extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_game_roms';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'game_rom_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['game_id', 'platform_id', 'romUrl'];
}
