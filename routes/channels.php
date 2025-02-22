<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Channel;
use App\Models\Message;

Broadcast::channel('chat.{channelId}', function ($user, $channelId) {
    $channel = Channel::find($channelId);
    return $user->id === $channel->user_id ||
        Message::where('channel_id', $channelId)
            ->where(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })->exists();
});