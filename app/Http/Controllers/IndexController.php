<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $games = Game::all();

        return view('index', ["games" => $games]);
    }
}
