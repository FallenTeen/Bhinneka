<?php

use App\Models\Channel;
use App\Models\Message;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{channelId}', function ($user, $channelId) {
    $channel = Channel::find($channelId);
    return $channel && ($channel->user_id === $user->id ||
        Message::where('channel_id', $channelId)
            ->where('sender_id', $user->id)
            ->exists());
});