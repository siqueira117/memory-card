<?php

namespace App\Http\Controllers;

use App\Models\Franchise;
use App\Models\Game as GameModel;
use App\Models\GameGenres;
use App\Models\GameManual;
use App\Models\GamePlatforms;
use App\Models\GameRom;
use App\Models\Language;
use App\Models\Platform;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use MarcReichel\IGDBLaravel\Enums\Image\Size;
use MarcReichel\IGDBLaravel\Models\Artwork;
use MarcReichel\IGDBLaravel\Models\Game as GameIgdb;

class GameController extends Controller
{
    public function index()
    {
        $games = GameModel::with(['roms', 'genres'])->limit(40)->orderBy('created_at', 'desc')->paginate(20);

        $return = [ 'games' => $games, 'allGames' => GameModel::count() ];

        if (Auth::check() && Auth::user()->type === 'adm') {
            $platformsToSelect = Platform::orderBy('name', 'asc')->get();
            $return['platformsToSelect'] = $platformsToSelect;

            $languages = Language::all();
            $return["languages"] = $languages;
        }

        return view('index', $return);
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
                throw new \Exception("{$game->name}: Não foi encontrado!");
            }
            // ==========================

            DB::beginTransaction();

            // Verificando se temos esse jogo cadastrado
            $gameResult = GameModel::where('game_id', $game->id)->get();
            if (count($gameResult)) {

                // Caso o jogo já esteja cadastrado, apenas adiciona a ROM
                $this->insertRoms($request, $game->id);

                $request->session()->flash('successMsg',"{$game->name}: Cadastrado com sucesso!"); 
                return Redirect::back();
            }
            // ==========================

            $gameModel = GameModel::create([
                "game_id"   => $game->id,
                "name"      => $game->name,
                "slug"      => $game->slug,
                "summary"   => $game->summary ?? null,
                "storyline" => $game->storyline ?? null,
                "first_release_date" => $game->first_release_date ?? null,
                "total_rating" => $game->total_rating ?? null,
                "coverUrl"  => "https:" . $game->cover->getUrl(Size::COVER_BIG, true)
            ]);
    
            if (!$gameModel) throw new \Exception("Não foi possível adicionar o jogo!");

            // Cadastrando manual
            if ($request->manualUrl || $request->manualPlatform || $request->manualLanguage) {
                $manualDados = [
                    'manualurl'      => $request->manualUrl, 
                    'manualPlatform' => $request->manualPlatform,
                    'manualLanguage' => $request->manualLanguage
                ];

                $validator = Validator::make($manualDados, [
                    'manualurl'       => 'required',
                    'manualPlatform'  => 'required',
                    'manualLanguage'  => 'required'
                ]);
                
                if (!$validator->passes()) {
                    return Redirect::back()->withErrors($validator);
                }

                $gameManual = GameManual::create([
                    'url'           => $request->manualUrl,
                    'game_id'       => $game->id,
                    'language_id'   => $request->manualLanguage,
                    'platform_id'   => $request->manualPlatform
                ]);

                if (!$gameManual) throw new \Exception("Não foi possível adicionar o manual!");
            }

            if ($game->genres) $this->insertGameGenres($game->genres, $game->id);

            if ($game->platforms) $this->insertGamePlatforms($game->platforms, $game->id);

            if ($game->franchises) $this->insertGameFranchises($game->franchises, $gameModel);

            if ($game->themes) $this->insertGameThemes($game->themes, $gameModel);

            if ($game->screenshots) $this->insertScreenshots($game->screenshots, $gameModel);

            $this->insertArtworks($game->id, $gameModel);

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

    private function insertScreenshots($screenshots, $gameModel)
    {
        if ($screenshots->isEmpty()) {
            return;
        }
    
        $gameModel->screenshots()->createMany(
            $screenshots->map(fn($screenshot) => [
                "screenshotUrl" => $screenshot->getUrl(Size::COVER_BIG, true)
            ])->toArray()
        );
    }

    private function insertArtworks(int $id, $gameModel)
    {
        $artworks = Artwork::where('game', $id)->get();
        $dados = [];
        if (count($artworks)) {
            foreach ($artworks as $artwork) {
                $url = $artwork->getUrl(Size::HD, true);
                $dados[] = [ "artworkUrl" => $url ];
            }

            $gameModel->artworks()->createMany($dados);
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
                ->with(['cover', 'artworks', 'videos', 'franchises', 'screenshots'])
                ->first();
        } else {
            return GameIgdb::search($request->gameName)
                ->orderBy('first_release_date', 'asc')
                ->with(['cover', 'artworks', 'videos', 'franchises', 'screenshots'])
                ->first();
        }
    }

    private function insertGameThemes(array $themes, $gameModel)
    {
        $gameModel->themes()->attach($themes);
    }

    public function details(string $slug)
    {
        try {
            $game = GameModel::with(['roms.platform', 'genres', 'platforms', 'franchises', 'screenshots', 'manuals.platform', 'manuals.language', 'artworks'])->where('slug', $slug)->first();
            if (!$game) {
                Session::flash('errorMsg',"{$slug}: Não foi encontrado!"); 
                return Redirect::back();
            }

            $platforms = $game->roms->map(fn ($rom) =>
                [
                    'platform_name' => $rom->platform->name,
                    'romUrl' => $rom->romUrl,
                ]
            );

            $relatedGames = GameModel::whereHas('franchises', function ($query) use ($game) {
                $query->whereIn('tbl_game_franchises.franchise_id', $game->franchises->pluck('franchise_id'));
            })->where('game_id', '!=', $game->game_id)->get();            

            return view('game-details', ['game' => $game, 'platforms' => $platforms, 'relatedGames' => $relatedGames]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function update()
    {
        $games = GameModel::all();
        foreach ($games as $game) {
            echo("Atualizando {$game['name']}...\n");

            $artworks = Artwork::where('game', $game->game_id)->get();
            $dados = [];
            if (count($artworks)) {
                foreach ($artworks as $artwork) {
                    $url = $artwork->getUrl(Size::HD, true);
                    $dados[] = [ "artworkUrl" => $url ];
                }

                $game->artworks()->createMany($dados);
                
                continue;
            }

            echo("Sem artworks...\n");
        }
    }
}
