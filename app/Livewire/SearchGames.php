<?php

namespace App\Livewire;

use App\Models\Game;
use Livewire\Component;
use Livewire\WithPagination;

class SearchGames extends Component
{
    use WithPagination;

    public $search = "";
    protected $paginationTheme = 'custom';
    public $platforms;
    public $allGames;

    public function updatingSearch()
    {
        $this->resetPage(); // Reseta a paginação ao buscar
    }

    public function render()
    {
        if (strlen($this->search) >= 5) {
            $games = Game::with(['roms', 'genres'])
                ->orderBy('created_at', 'desc')
                ->where('name', 'ilike', '%'.$this->search.'%')
                ->paginate(30);
        } else {
            $games = Game::with(['roms', 'genres'])
                ->orderBy('created_at', 'desc')
                ->paginate(30);
        }

        return view('livewire.search-games', compact('games'));
    }
}
