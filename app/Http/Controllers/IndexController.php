<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameRom;
use App\Models\Platform;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $games      = Game::with('roms')->get();
        $platforms  = [];
        foreach ($games as $game) {
            $roms = $game->roms;
            foreach ($roms as $rom) {
                $platform = Platform::where('platform_id', $rom->platform_id)->first();
                $platforms[$game->game_id][] = ['platform_name' => $platform->name, 'romUrl' => $rom->romUrl ];
            }
        }

        return view('index', ["games" => $games, "platforms" => $platforms ]);
    }
}
