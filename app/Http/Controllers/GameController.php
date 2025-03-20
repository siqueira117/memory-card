<?php

namespace App\Http\Controllers;

use App\Models\Collection as ModelsCollection;
use App\Models\Game as GameModel;
use App\Models\{Company, Franchise, GameGenres, Language, Platform, GameRom, GameManual, GamePlatforms, UserGame};
use Illuminate\Support\Facades\{Auth, DB, Log, Redirect, Session};
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
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
        $validator = Validator::make($request->all(), [
            'gameId'        => 'required|integer',
            'gameDownload'  => 'required|url',
            'gamePlatform'  => 'required|integer'
        ]);
    
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
    
        try {
            DB::beginTransaction();
    
            // Buscar jogo no IGDB
            $game = $this->getGameData($request);
            if (!$game) {
                throw new \Exception("Jogo não encontrado no IGDB.");
            }
    
            // Verificar se já existe no banco
            $gameModel = GameModel::firstOrCreate([
                'game_id' => $game->id
            ], [
                "name"                  => $game->name,
                "slug"                  => $game->slug,
                "summary"               => $game->summary               ?? null,
                "storyline"             => $game->storyline             ?? null,
                "first_release_date"    => $game->first_release_date    ?? null,
                "total_rating"          => $game->total_rating          ?? null,
                "coverUrl"              => "https:" . $game->cover->getUrl(Size::COVER_BIG, true)
            ]);
    
            // Se o jogo já existia, apenas insere a ROM
            if (!$gameModel->wasRecentlyCreated) {
                $this->insertRoms($request, $game->id);
            
                $request->session()->flash('successMsg', "{$game->name}: ROM adicionada com sucesso!");
                return Redirect::back();
            }
            
            // Inserir manual
            $this->insertManual($request, $game);

            // Inserir ROMs
            $this->insertRoms($request, $game->id);
    
            // Inserir coleções, franquias, temas e plataformas
            $this->insertRelations($game, $gameModel);
    
            DB::commit();
    
            $request->session()->flash('successMsg', "{$game->name}: Cadastrado com sucesso!");
            return Redirect::back();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Erro ao cadastrar jogo: " . $e->getMessage());
            return Redirect::back()->with('errorMsg', 'Erro ao cadastrar jogo.');
        }
    }
    
    private function insertManual($request, $game)
    {
        if ($request->manualUrl || $request->manualPlatform || $request->manualLanguage) {
            // Dados do manual que estão sendo enviados
            $manualDados = [
                'manualurl' => $request->manualUrl,
                'manualPlatform' => $request->manualPlatform,
                'manualLanguage' => $request->manualLanguage
            ];
        
            // Validação dos dados
            $validator = Validator::make($manualDados, [
                'manualurl' => 'required|url',
                'manualPlatform' => 'required|integer|exists:tbl_platforms,platform_id',
                'manualLanguage' => 'required|integer|exists:tbl_languages,language_id'
            ]);
        
            if ($validator->fails()) {
                // Se a validação falhar, redireciona de volta com os erros
                return Redirect::back()->withErrors($validator);
            }
        
            // Criar ou verificar se o manual já existe
            $gameManual = GameManual::firstOrCreate(
                [ 'game_id' => $game->id, 'platform_id' => $request->manualPlatform, 'language_id' => $request->manualLanguage ],
                [ 'url' => $request->manualUrl ]
            );
        
            // Caso não tenha sido possível criar o manual, lança uma exceção com o erro
            if (!$gameManual) {
                Log::error('Erro ao criar o manual para o jogo ' . $game->name, [
                    'game_id' => $game->id,
                    'manual_url' => $request->manualUrl,
                    'platform_id' => $request->manualPlatform,
                    'language_id' => $request->manualLanguage
                ]);
                throw new \Exception("Não foi possível adicionar o manual ao jogo {$game->name}.");
            }
        }
    }

    private function insertRelations($game, $gameModel)
    {
        if ($game->genres) {
            $gameModel->genres()->syncWithoutDetaching($game->genres);
        }

        if ($game->platforms) {
            $gameModel->platforms()->syncWithoutDetaching($game->platforms);
        }

        if ($game->franchises) {
            $this->attachOrCreate(Franchise::class, $game->franchises, 'franchise_id', $gameModel->franchises());
        }

        if ($game->collections) {
            $this->attachOrCreate(ModelsCollection::class, $game->collections, 'collection_id', $gameModel->collections());
        }

        if ($game->themes) {
            $gameModel->themes()->syncWithoutDetaching($game->themes);
        }

        if ($game->screenshots) {
            $this->insertScreenshots($game->screenshots, $gameModel);
        }

        if ($game->involved_companies) {
            $this->insertInvolvedCompanies($game->involved_companies, $gameModel);
        }

        $this->insertArtworks($game->id, $gameModel);
    }

    private function attachOrCreate($model, $items, $idField, $relation)
    {
        $ids = [];
        foreach ($items as $item) {
            $record = $model::firstOrCreate(
                [$idField => $item->id],
                ['name' => $item->name, 'slug' => $item->slug]
            );
            $ids[] = $record->$idField;
        }

        $relation->syncWithoutDetaching($ids);
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

    private function insertInvolvedCompanies($involvedCompanies, $gameModel)
    {
        $companiesData = [];
        
        foreach ($involvedCompanies as $involvedCompany) {
            $companyData = $involvedCompany->company;
            
            $company = Company::firstOrCreate(
                ['company_id' => $companyData->id],
                [
                    'name'        => $companyData->name,
                    'slug'        => $companyData->slug,
                    'description' => $companyData->description ?? null,
                    'status'      => $this->getCompanyStatus($companyData->status)
                ]
            );
    
            $companiesData[$company->company_id] = [
                'developer'  => $involvedCompany->developer,
                'porting'    => $involvedCompany->porting,
                'publisher'  => $involvedCompany->publisher,
                'supporting' => $involvedCompany->supporting,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
    
        $gameModel->companies()->syncWithoutDetaching($companiesData);
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

    private function getGameData(Request $request)
    {
        $query = GameIgdb::with(['cover', 'artworks', 'videos', 'franchises', 'screenshots', 'collections', 'involved_companies', 'involved_companies.company'])
            ->orderBy('first_release_date', 'asc');
    
        return $request->gameId
            ? $query->where('id', (int)$request->gameId)->first()
            : $query->search($request->gameName)->first();
    }

    public function details(string $slug)
    {
        try {
            $game = GameModel::with([
                'roms.platform', 'genres', 'platforms', 'franchises',
                'screenshots', 'manuals.platform', 'manuals.language', 
                'artworks', 'collections', 'userGames'
            ])->where('slug', $slug)->firstOrFail();
                
            $platforms = $game->roms->map(fn ($rom) => [
                'platform_name' => $rom->platform->name,
                'romUrl' => $rom->romUrl,
            ]);
    
            $relatedGames = GameModel::whereHas('franchises', function ($query) use ($game) {
                $query->whereIn('tbl_game_franchises.franchise_id', $game->franchises->pluck('franchise_id'));
            })->whereHas('collections', function ($query) use ($game) {
                $query->whereIn('tbl_game_collections.collection_id', $game->collections->pluck('collection_id'));
            })->where('game_id', '!=', $game->game_id)->get();

            return view('game-details', compact('game', 'platforms', 'relatedGames'));
        } catch (\Exception $e) {
            Log::error("Erro ao buscar detalhes do jogo: " . $e->getMessage());
            return Redirect::back()->with('errorMsg', 'Erro ao carregar detalhes.');
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            $user = Auth::user();
            $gameId = $request->input('game_id');
            $status = $request->input('status');
    
            Log::alert($user);
            $userGame = UserGame::updateOrCreate(
                ['user_id' => $user->id, 'game_id' => $gameId],
                ['status' => $status]
            );
    
            return response()->json(['success' => true, 'status' => $userGame->status]);                
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function update()
    {
        $games = GameModel::all();
        foreach ($games as $game) {
            echo("Atualizando {$game['name']}...\n");
    
            $gameIgdb = GameIgdb::with(['involved_companies.company', 'involved_companies'])->where('slug', $game->slug)->first();
            if (!$gameIgdb || !$gameIgdb->involved_companies) {
                echo("Sem companies...\n");
                continue;
            }

            foreach ($gameIgdb->involved_companies as $involved_company) {
                // Verifica se a collection já existe antes de adicionar

                $game->companies()->attach($involved_company->company->id, [
                    'developer'  => $involved_company->developer,
                    'porting'    => $involved_company->porting,
                    'publisher'  => $involved_company->publisher,
                    'supporting' => $involved_company->supporting,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
    
                echo("Company cadastrada\n");
            }
            echo("\n\n");
            //     // Adiciona a collection ao jogo se ainda não estiver associada
                // if (!$game->collections()->where('tbl_game_collections.collection_id', $collectionModel->collection_id)->exists()) {
                //     $game->collections()->attach($collectionModel->collection_id);
                //     echo("Collection '{$collection->name}' adicionada ao jogo {$game['name']}!\n");
                // } else {
                //     echo("Collection '{$collection->name}' já está associada a {$game['name']}.\n");
                // }
        }
    }

    private function getCompanyStatus(?int $status)
    {
        if (!$status) {
            return "defunct";
        }

        $dePara = [
            0 => "active",
            1 => "defunct",
            2 => "merged",
            3 => "renamed"
        ];

        return $dePara[$status];
    }
    
    
}
