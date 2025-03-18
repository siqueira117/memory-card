<?php

namespace App\Listeners;

use App\Events\GameCreated;
use App\Models\Activity;
use App\Models\User;
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
        $activity = Activity::create([
            'description'   => "Novo jogo: {$event->game->name}",
            'model_type'    => 'game',
            'model_id'      => $event->game->game_id,
            'model_uri'     => "/game/{$event->game->slug}"
        ]);

        $users = User::all();
        foreach ($users as $user) {
            $user->activities()->attach($activity->activity_id);
        }
    }
}
