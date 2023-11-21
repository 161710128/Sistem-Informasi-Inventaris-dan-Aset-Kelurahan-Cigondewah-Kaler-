<?php

namespace App\Events;

use App\Models\Inventaris;
use App\Models\Pengembalian;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PengembalianDiterima
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $peminjamanId;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($peminjamanId)
    {
        $this->peminjamanId = $peminjamanId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
