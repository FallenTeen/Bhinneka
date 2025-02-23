<?php

namespace App\Providers;

use App\Models\Channel;
use App\Observers\ChannelObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{

    protected $observers = [
        Channel::class => [ChannelObserver::class],
    ];

}