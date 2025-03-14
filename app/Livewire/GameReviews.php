<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\GameReview;
use Illuminate\Support\Facades\Auth;

class GameReviews extends Component {
    public $gameId;
    public $rating = 5;
    public $review;

    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'review' => 'required|string|min:10|max:1000',
    ];

    public function mount($gameId) {
        $this->gameId = $gameId;
    }

    public function submitReview() {
        $this->validate();

        if (!Auth::check()) {
            session()->flash('error', 'Você precisa estar logado para avaliar.');
            return;
        }

        GameReview::create([
            'user_id' => Auth::id(),
            'game_id' => $this->gameId,
            'rating' => $this->rating,
            'review' => $this->review,
        ]);

        $this->reset('rating', 'review');
        session()->flash('success', 'Review enviado com sucesso!');
    }

    public function render() {
        $reviews = GameReview::where('game_id', $this->gameId)
            ->latest()
            ->get();

        return view('livewire.game-reviews', compact('reviews'));
    }
}