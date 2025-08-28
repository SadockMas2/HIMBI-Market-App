<?php
namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommandeConfirmee implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $commande;

    public function __construct($commande)
    {
        $this->commande = $commande;
    }

    public function broadcastOn()
    {
        return new Channel('commandes');
    }

    public function broadcastAs()
    {
        return 'commande.confirmee';
    }
}
