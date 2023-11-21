<?php

namespace App\Events;

use App\Models\Barang_habis_pakai;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EntriPemakaianBarangHabis
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $pemakaianBarangHabis;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Barang_habis_pakai $pemakaianBarangHabis)
    {
        $this->pemakaianBarangHabis = $pemakaianBarangHabis;
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
