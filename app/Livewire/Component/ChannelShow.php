<?php

namespace App\Livewire\Component;

use App\Models\Channel;
use Livewire\Component;

class ChannelShow extends Component
{
    public $channel, $slug, $externalLinks;
    public $contentVideos;

    public function mount($slug)
    {
        $this->channel = Channel::where('slug', $slug)->firstOrFail();
        $this->contentVideos = $this->channel->contentVideos;
        $this->externalLinks = json_decode($this->channel->exlink, true);
    }

    public function render()
    {
        return view('livewire.component.channel-show');
    }
}