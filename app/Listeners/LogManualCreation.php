<?php

namespace App\Listeners;

use App\Events\ManualCreated;
use App\Models\Activity;
use App\Models\Log;
use App\Models\User;
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
        $activity = Activity::create([
            'description'   => "Novo manual: {$event->manual->game->name}",
            'model_type'    => 'manual',
            'model_id'      => $event->manual->game_manual_id,
            'model_uri'     => "/game/{$event->manual->game->slug}"
        ]);

        $users = User::all();
        foreach ($users as $user) {
            $user->activities()->attach($activity->activity_id);
        }
    }
}
