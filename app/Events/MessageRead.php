<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageRead implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $messageId;
    public $channelId;
    public $readBy;

    public function __construct($messageId, $channelId, $readBy)
    {
        $this->messageId = $messageId;
        $this->channelId = $channelId;
        $this->readBy = $readBy;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.' . $this->channelId),
        ];
    }
}