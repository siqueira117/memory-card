<?php

namespace App\Events;

use App\Models\GameManual;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ManualCreated
{
    use Dispatchable, SerializesModels;

    public $manual;

    public function __construct(GameManual $manual)
    {
        $this->manual = $manual;
    }
}
