<?php

namespace App\Livewire\Component;

use App\Models\Channel;
use Livewire\Component;

class ChannelShow extends Component
{
    public $channel;
    public $contentVideos;

    public function mount($slug)
    {
        $this->channel = Channel::where('slug', $slug)->firstOrFail();
        $this->contentVideos = $this->channel->contentVideos;
    }

    public function render()
    {
        return view('livewire.component.channel-show')->layout('layouts.app');
    }
}