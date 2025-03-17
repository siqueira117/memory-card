<?php

namespace App\Listeners;

use App\Events\ManualCreated;
use App\Models\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogManualCreation
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
    public function handle(ManualCreated $event)
    {
        Log::create([
            'description'   => "Novo manual adicionado para o jogo: {$event->manual->game->name}",
            'model_type'    => 'manual',
            'model_id'      => $event->manual->game_manual_id
        ]);
    }
}
