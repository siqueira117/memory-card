<?php

namespace App\Http\Controllers;

use App\Models\Franchise;
use App\Models\Game as GameModel;
use App\Models\GameGenres;
use App\Models\GamePlatforms;
use App\Models\GameRom;
use App\Models\Platform;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use MarcReichel\IGDBLaravel\Enums\Image\Size;
use MarcReichel\IGDBLaravel\Models\Game as GameIgdb;

class GameController extends Controller
{
    public function index()
    {
        $games      = GameModel::with(['roms'])->limit(20)->get();
        $platforms  = [];
        foreach ($games as $game) {
            $roms = $game->roms;
            foreach ($roms as $rom) {
                $platform = Platform::where('platform_id', $rom->platform_id)->first();
                $platforms[$game->game_id][] = [ 'platform_name' => $platform->name, 'romUrl' => $rom->romUrl ];
            }
        }

        return view('index', ['games' => $games, 'platforms' => $platforms]);
    }
    
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'gameId'        => 'required',
                'gameDownload'  => 'required',
                'gamePlatform'  => 'required'
            ]);
            
            if (!$validator->passes()) {
                return Redirect::back()->withErrors($validator);
            }
    
            // Consultando API do IGDB
            $game = $this->getGameData($request);
            if (!$game) {
                $request->session()->flash('errorMsg',"{$game->name}: Não foi encontrado!"); 
                return Redirect::back();
            }
            // ==========================

            // Verificando se temos esse jogo cadastrado
            $gameResult = GameModel::where('game_id', $game->id)->get();
            if (count($gameResult)) {

                // Caso o jogo já esteja cadastrado, apenas adiciona a ROM
                $this->insertRoms($request, $game->id);

                $request->session()->flash('successMsg',"{$game->name}: Cadastrado com sucesso!"); 
                return Redirect::back();
            }
            // ==========================

            DB::beginTransaction();

            $gameModel = GameModel::create([
                "game_id"   => $game->id,
                "name"      => $game->name,
                "slug"      => $game->slug,
                "summary"   => $game->summary ?? null,
                "storyline" => $game->storyline ?? null,
                "coverUrl"  => "https:" . $game->cover->getUrl(Size::COVER_BIG, true)
            ]);
    
            if (!$gameModel) throw new \Exception("Não foi possível adicionar o jogo!");

            if ($game->genres) $this->insertGameGenres($game->genres, $game->id);

            if ($game->platforms) $this->insertGamePlatforms($game->platforms, $game->id);

            if ($game->franchises) $this->insertGameFranchises($game->franchises, $gameModel);

            if ($game->themes) $this->insertGameThemes($game->themes, $gameModel);

            $this->insertRoms($request, $game->id);
    
            DB::commit();

            $request->session()->flash('successMsg',"{$game->name}: Cadastrado com sucesso!"); 
            return Redirect::back();
        } catch (\Exception $e) {
            DB::rollBack();
            $request->session()->flash('errorMsg', $e->getMessage()); 
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

    private function insertGameFranchises(Collection $franchises, $gameModel) 
    {
        $franchisesIds = [];
        foreach ($franchises as $franchise) {
            $newFranchise = Franchise::firstOrCreate([
                'franchise_id' => $franchise->id, 
                'name' => $franchise->name, 
                'slug' => $franchise->slug
            ]);

            $franchisesIds[] = $newFranchise->franchise_id;
        }

        $gameModel->franchises()->attach($franchisesIds);
    }

    private function getGameData(Request $request)
    {
        if ($request->gameId) {
            return GameIgdb::where('id', '=', intval($request->gameId))
                ->orderBy('first_release_date', 'asc')
                ->with(['cover', 'artworks', 'videos', 'franchises'])
                ->first();
        } else {
            return GameIgdb::search($request->gameName)
                ->orderBy('first_release_date', 'asc')
                ->with(['cover', 'artworks', 'videos', 'franchises'])
                ->first();
        }
    }

    private function insertGameThemes(array $themes, $gameModel)
    {
        $gameModel->themes()->attach($themes);
    }

    public function details($slug)
    {
        try {
            $game = GameModel::where('slug', $slug)->first();
            if (!$game) {
                Session::flash('errorMsg',"{$slug}: Não foi encontrado!"); 
                return Redirect::back();
            }
    
            // $gameIgdb = GameIgdb::where('slug', $slug)->with(['cover', 'artworks', 'videos'])->get();
            // dd($gameIgdb);

            return view('game-details', ['game' => $game]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
