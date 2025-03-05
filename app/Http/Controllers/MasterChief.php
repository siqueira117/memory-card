<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Platform;
use Illuminate\Http\Request;

class MasterChief extends Controller
{
    public function index()
    {
        $platforms = Platform::orderBy('name', 'asc')->get();
        $games = Game::all();

        return view('master-chief', ["platforms" => $platforms, 'games' => $games]);
    }
}
