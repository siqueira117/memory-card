<?php

namespace App\Livewire;

use App\Models\Game;
use App\Models\Genre;
use App\Models\Platform;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use Livewire\WithPagination;

class SearchGames extends Component
{
    use WithPagination;

    protected $paginationTheme = 'custom';
    public $platforms = [];
    public $genres = [];
    public $allGames;

    public $search = ''; // Pesquisa
    public $genre = ''; // Filtro de gênero
    public $platform = ''; // Filtro de plataforma
    public $orderBy = 'created_at'; // Campo de ordenação
    public $orderDirection = false; // Direção da ordenação

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingGenre()
    {
        $this->resetPage();
    }

    public function updatingPlatform()
    {
        $this->resetPage();
    }

    public function updatingOrderBy()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->platforms = Cache::remember('platforms', 3600, fn() => Platform::orderBy('name')->get()->toArray());
        $this->genres = Cache::remember('genres', 3600, fn() => Genre::all()->toArray());
    }

    public function render()
    {
        $games = Game::with(['platforms', 'genres'])
        ->when($this->search, fn($query) => 
            $query->where('name', 'ilike', '%' . $this->search . '%'))
        ->when($this->genre, fn($query) => 
            $query->whereHas('genres', fn($q) => $q->where('tbl_game_genres.genre_id', $this->genre)))
        ->when($this->platform, fn($query) => 
            $query->whereHas('platforms', fn($q) => $q->where('tbl_game_platforms.platform_id', $this->platform)))
        ->orderBy($this->orderBy, ($this->orderDirection ? 'asc' : 'desc'))
        ->paginate(30);

        return view('livewire.search-games', compact('games'));
    }
}
