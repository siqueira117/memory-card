<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    const __GENRES__ = [
        ["genre_id" => 2, "name" => "Point-and-click", "slug" => "point-and-click"],
        ["genre_id" => 4, "name" => "Fighting", "slug" => "fighting"],
        ["genre_id" => 5, "name" => "Shooter", "slug" => "shooter"],
        ["genre_id" => 7, "name" => "Music", "slug" => "music"],
        ["genre_id" => 8, "name" => "Platform", "slug" => "platform"],
        ["genre_id" => 9, "name" => "Puzzle", "slug" => "puzzle"],
        ["genre_id" => 10, "name" => "Racing", "slug" => "racing"],
        ["genre_id" => 11, "name" => "Real Time Strategy (RTS)", "slug" => "real-time-strategy-rts"],
        ["genre_id" => 12, "name" => "Role-playing (RPG)", "slug" => "role-playing-rpg"],
        ["genre_id" => 13, "name" => "Simulator", "slug" => "simulator"],
        ["genre_id" => 14, "name" => "Sport", "slug" => "sport"],
        ["genre_id" => 15, "name" => "Strategy", "slug" => "strategy"],
        ["genre_id" => 16, "name" => "Turn-based strategy (TBS)", "slug" => "turn-based-strategy-tbs"],
        ["genre_id" => 24, "name" => "Tactical", "slug" => "tactical"],
        ["genre_id" => 25, "name" => "Hack and slash/Beat 'em up", "slug" => "hack-and-slash-beat-em-up"],
        ["genre_id" => 26, "name" => "Quiz/Trivia", "slug" => "quiz-trivia"],
        ["genre_id" => 30, "name" => "Pinball", "slug" => "pinball"],
        ["genre_id" => 31, "name" => "Adventure", "slug" => "adventure"],
        ["genre_id" => 32, "name" => "Indie", "slug" => "indie"],
        ["genre_id" => 33, "name" => "Arcade", "slug" => "arcade"],
        ["genre_id" => 34, "name" => "Visual Novel", "slug" => "visual-novel"],
        ["genre_id" => 35, "name" => "Card & Board Game", "slug" => "card-and-board-game"],
        ["genre_id" => 36, "name" => "MOBA", "slug" => "moba"]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::__GENRES__ as $genre) {
            Genre::create($genre);
        }
    }
}
