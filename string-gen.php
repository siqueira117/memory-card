<?php

require_once(__DIR__."/vendor/autoload.php");

use App\Models\Game;
use MarcReichel\IGDBLaravel\Enums\Image\Size;
use MarcReichel\IGDBLaravel\Models\Game as ModelsGame;

$games = Game::all();
$dados = [];
foreach ($games as $game) {
    echo("Atualizando {$game['name']}...\n");
    $gameIgdb = ModelsGame::where('slug', $game->slug)
        ->with(['screenshots'])
        ->first();
    
    if ($gameIgdb->screenshots) {
        foreach ($gameIgdb->screenshots as $screenshot) {
            $url = $screenshot->getUrl(Size::COVER_BIG, true);
            $dados[] = [ "screenshotUrl" => $url ];
        }
    }
    $game->screenshots()->createMany($dados);
    echo("{$game['name']}: Atualizado com sucesso!\n");
}