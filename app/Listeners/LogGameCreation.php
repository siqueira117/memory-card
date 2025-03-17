<?php

namespace App\Listeners;

use App\Events\GameCreated;
use App\Models\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogGameCreation
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(GameCreated $event)
    {
        Log::create([
            'description'   => "Novo jogo adicionado: {$event->game->name}",
            'model_type'    => 'game',
            'model_id'      => $event->game->game_id
        ]);
    }
}
