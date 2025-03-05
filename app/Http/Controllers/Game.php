<?php

namespace App\Http\Controllers;

use App\Models\Game as GameModel;
use App\Models\GameGenres;
use App\Models\GamePlatforms;
use App\Models\GameRom;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use MarcReichel\IGDBLaravel\Enums\Image\Size;
use MarcReichel\IGDBLaravel\Models\Game as GameIgdb;

class Game extends Controller
{
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'gameName'      => 'required',
                'gameDownload'  => 'required',
                'gamePlatform'  => 'required'
            ]);
            
            if (!$validator->passes()) {
                return Redirect::back()->withErrors($validator);
            }
    
            $game = GameIgdb::search($request->gameName)
                ->orderBy('first_release_date', 'asc')
                ->with(['cover'])
                ->first();
            
            if (!$game) {
                $request->session()->flash('errorMsg',"{$game->name}: Não foi encontrado!"); 
                return Redirect::back();
            }

            DB::beginTransaction();
    
            $gameModel = GameModel::create([
                'game_id'   => $game->id,
                'name'      => $game->name,
                'slug'      => $game->slug,
                'summary'   => $game->summary,
                'coverUrl'  => "https:" . $game->cover->getUrl(Size::COVER_BIG, true)
            ]);
    
            if (!$gameModel) {
                DB::rollBack();
                throw new \Exception("ERRO ao adicionar jogo!");
            }

            if ($game->genres) $this->insertGameGenres($game->genres, $game->id);

            if ($game->platforms) $this->insertGamePlatforms($game->platforms, $game->id);

            $this->insertRoms($request, $game->id);
    
            DB::commit();

            $request->session()->flash('successMsg',"{$game->name}: Cadastrado com sucesso!"); 
            return Redirect::back();
        } catch (\Exception $e) {
            dd($e);
            return Redirect::back();
        }
    }

    private function insertGameGenres(array $genres, int $gameId)
    {
        foreach ($genres as $genreId) {
            GameGenres::create([ 'game_id' => $gameId, 'genre_id' => $genreId ]);
        }
    }

    private function insertGamePlatforms(array $platforms, int $gameId)
    {
        foreach ($platforms as $platformsId) {
            GamePlatforms::create([ 'game_id' => $gameId, 'platform_id' => $platformsId ]);
        }
    }

    private function insertRoms($request, int $gameId)
    {
        $gameRom = [ 
            'game_id'       => $gameId, 
            'platform_id'   => (int)$request['gamePlatform'],  
            'romUrl'        => $request->gameDownload 
        ];

        GameRom::create($gameRom);
    }
}
