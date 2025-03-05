<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $games = [
            [
                "name" => "The Sims 2",
                "coverUrl" => "https://cdn.mobygames.com/covers/4184315-the-sims-2-windows-front-cover.jpg",
                "romPlatform" => "PC",
                "downloadUrl" => "https://cdn.mobygames.com/covers/4184315-the-sims-2-windows-front-cover.jpg"
            ],
            [
                "name" => "The Sims 2",
                "coverUrl" => "https://cdn.mobygames.com/covers/4184315-the-sims-2-windows-front-cover.jpg",
                "romPlatform" => "PC",
                "downloadUrl" => "https://cdn.mobygames.com/covers/4184315-the-sims-2-windows-front-cover.jpg"
            ]
        ];

        return view('index', ["games" => $games]);
    }
}
