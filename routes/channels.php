<?php

use App\Models\Channel;
use App\Models\Message;
use Illuminate\Support\Facades\Broadcast;
Broadcast::channel('global-messages', function ($user) {
    return true;
});

Broadcast::channel('chat.{channelId}', function ($user, $channelId) {
    if ($user->role_id == 2) {
        return true;
    }

    $channel = Channel::find($channelId);
    return $channel && ($channel->user_id === $user->id ||
        Message::where('channel_id', $channelId)
            ->where(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })
            ->exists());
});