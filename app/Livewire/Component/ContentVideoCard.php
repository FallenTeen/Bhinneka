<?php

namespace App\Livewire\Component;

use Livewire\Component;
use App\Models\ContentVideo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class ContentVideoCard extends Component
{
    public $contentVideos, $jml_display = 12;

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

    public function mount()
    {
        $this->contentVideos = ContentVideo::with('channel')->take($this->jml_display)->inRandomOrder()->get()->map(function ($video) {
            $video->thumb = $this->getGoogleDriveThumbnail($video->url);
            return $video;
        });
    }
    public function render()
    {
        $user = Auth::user();
        $isSubscribed = $user && $user->subscribed;
        return view('livewire.component.content-video-card', [
            'contentVideos' => $this->contentVideos,
            'isSubscribed' => $isSubscribed,
        ]);
    }

}
