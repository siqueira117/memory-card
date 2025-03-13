<?php

namespace App\Livewire;

use App\Models\Game;
use Livewire\Component;
use Livewire\WithPagination;

class SearchGames extends Component
{
    use WithPagination;

    protected $paginationTheme = 'custom';
    public $platforms;
    public $allGames;

    public $search = ''; // Pesquisa
    public $genre = ''; // Filtro de gênero
    public $platform = ''; // Filtro de plataforma
    public $orderBy = 'name'; // Campo de ordenação
    public $orderDirection = true; // Direção da ordenação

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

    public function render()
    {
        // if (strlen($this->search) >= 5) {
        //     $games = Game::with(['genres'])
        //         ->orderBy('created_at', 'desc')
        //         ->where('name', 'ilike', '%'.$this->search.'%')
        //         ->paginate(30);
        // } else {
        //     $games = Game::with(['genres'])
        //         ->orderBy('created_at', 'desc')
        //         ->paginate(30);
        // }

        $games = Game::with(['platforms', 'genres'])
        ->when($this->search, fn($query) => 
            $query->where('name', 'like', '%' . $this->search . '%'))
        ->when($this->genre, fn($query) => 
            $query->whereHas('genres', fn($q) => $q->where('tbl_game_genres.genre_id', $this->genre)))
        ->when($this->platform, fn($query) => 
            $query->whereHas('platforms', fn($q) => $q->where('tbl_game_platforms.platform_id', $this->platform)))
        ->orderBy($this->orderBy, ($this->orderDirection ? 'asc' : 'desc'))
        ->paginate(20);

        return view('livewire.search-games', compact('games'));
    }
}
