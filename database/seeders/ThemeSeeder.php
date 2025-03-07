<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    use WithoutModelEvents;

    const __THEMES__ = [
        [ "theme_id" => 31, "name" => "Drama", "slug" => "drama" ],
        [ "theme_id" => 32, "name" => "Non-fiction", "slug" => "non-fiction" ],
        [ "theme_id" => 33, "name" => "Sandbox", "slug" => "sandbox" ],
        [ "theme_id" => 34, "name" => "Educational", "slug" => "educational" ],
        [ "theme_id" => 35, "name" => "Kids", "slug" => "kids" ],
        [ "theme_id" => 38, "name" => "Open world", "slug" => "open-world" ],
        [ "theme_id" => 39, "name" => "Warfare", "slug" => "warfare"],
        [ "theme_id" => 40, "name" => "Party", "slug" => "party"],
        [ "theme_id" => 41, "name" => "4X (explore, expand, exploit, and exterminate)", "slug" => "4x-explore-expand-exploit-and-exterminate"],
        [ "theme_id" => 42, "name" => "Erotic", "slug" => "erotic"],
        [ "theme_id" => 43, "name" => "Mystery", "slug" => "mystery"],
        [ "theme_id" => 1, "name" => "Action", "slug" => "action"],
        [ "theme_id" => 17, "name" => "Fantasy", "slug" => "fantasy"],
        [ "theme_id" => 18, "name" => "Science fiction", "slug" => "science-fiction"],
        [ "theme_id" => 19, "name" => "Horror", "slug" => "horror"],
        [ "theme_id" => 20, "name" => "Thriller", "slug" => "thriller"],
        [ "theme_id" => 21, "name" => "Survival", "slug" => "survival"],
        [ "theme_id" => 22, "name" => "Historical", "slug" => "historical"],
        [ "theme_id" => 23, "name" => "Stealth", "slug" => "stealth"],
        [ "theme_id" => 27, "name" => "Comedy", "slug" => "comedy"],
        [ "theme_id" => 28, "name" => "Business", "slug" => "business"],
        [ "theme_id" => 44, "name" => "Romance", "slug" => "romance"]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::__THEMES__ as $theme) {
            Theme::create($theme);
        }
    }
}
