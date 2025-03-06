<?php

namespace App\Livewire;

use App\Models\Game;
use Livewire\Component;

class SearchGames extends Component
{
    public $search = "";
    public $games = [];
    public $platforms;
    public $originalGames = [];

    public function render()
    {
        if (count($this->games) >= 1 && count($this->originalGames) < 1) {
            $this->originalGames = $this->games;
        }

        $games = [];

        if (strlen($this->search) >= 1) {
            $games = Game::where('name', 'like', '%'.$this->search.'%')->limit(5)->get();
            $this->games = $games;
        } else {
            $this->games = $this->originalGames;
        }

        return view('livewire.search-games');
    }
}
