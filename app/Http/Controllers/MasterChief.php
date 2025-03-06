<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Platform;

class MasterChief extends Controller
{
    public function index()
    {
        $platformsToSelect = Platform::orderBy('name', 'asc')->get();
        $games      = Game::with('roms')->get();
        $platforms  = [];
        foreach ($games as $game) {
            $roms = $game->roms;
            foreach ($roms as $rom) {
                $platform = Platform::where('platform_id', $rom->platform_id)->first();
                $platforms[$game->game_id][] = ['platform_name' => $platform->name, 'romUrl' => $rom->romUrl ];
            }
        }

        return view('index', ['platformsToSelect' => $platformsToSelect, 'games' => $games, 'platforms' => $platforms]);
    }
}
