<?php

namespace App\Livewire\Component;

use Livewire\Component;
use App\Models\ContentVideo;
use App\Models\Channel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class ContentShow extends Component
{
    public $contentVideos, $channel, $thumb;

    private function getGoogleDriveThumbnail($url)
    {
        if (preg_match('/\/d\/(.*?)\//', $url, $matches)) {
            $fileId = $matches[1];
            $thumbnailUrl = "https://drive.google.com/thumbnail?id={$fileId}";
        } else {
            $thumbnailUrl = 'https://via.placeholder.com/300';
        }
        return Crypt::encryptString($thumbnailUrl);
    }

    public function mount($slug)
    {
        $user = Auth::user();
        $this->contentVideos = ContentVideo::where('slug', $slug)->where('show', true)->firstOrFail();
        $this->isOwner = $user && $user->channels->contains('id', $this->contentVideos->channel->id);
        $this->thumb = $this->getGoogleDriveThumbnail($this->contentVideos->url);
        $this->channel = $this->contentVideos->channel;
    }


    public function render()
    {
        $user = Auth::user();
        $isSubscribed = $user && $user->subscribed;
        return view('livewire.component.content-show', [
            'contentVideos' => $this->contentVideos,
            'isOwner' => $this->isOwner,
            'thumb' => $this->thumb,
            'isSubscribed' => $isSubscribed,
        ]);
    }
}
