<?php

namespace App\Observers;

use App\Models\Channel;

class ChannelObserver
{
    public function deleted(Channel $channel)
    {
        if ($channel->user->channels->count() === 1) {
            $channel->user->role_id = 4;
            $channel->user->save();
        }
    }
}