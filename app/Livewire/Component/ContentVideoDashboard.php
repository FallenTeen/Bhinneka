<?php

namespace App\Livewire\Component;

use Livewire\Component;
use App\Models\ContentVideo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class ContentVideoDashboard extends Component
{
    public $contentVideos, $jml_display = 4, $slug;
    public $hidename = false;

    private function getGoogleDriveThumbnail($url)
    {
        if (preg_match('/\/d\/(.*?)\//', $url, $matches)) {
            $fileId = $matches[1];
            $thumbnailUrl = "https://drive.google.com/thumbnail?id={$fileId}";
        } else {
            $thumbnailUrl = 'https://via.placeholder.com/300';
        }
        $encodedUrl = Crypt::encryptString($thumbnailUrl);
        return route('thumbnail', ['encodedUrl' => $encodedUrl]);
    }



    public function loadMore()
    {
        $this->jml_display += 4;
        $this->updateContentVideos();
    }
    public function toggleShow($slug)
    {
        $video = ContentVideo::find($slug);

        if ($video) {
            $video->show = !$video->show;
            $video->save();
        }
    }

    public function mount($slug)
    {
        $user = Auth::user();
        $query = ContentVideo::with('channel');
        $this->contentVideos = $query->whereHas('channel', function ($q) use ($slug) {
            $q->where('slug', $slug);
        })
            ->inRandomOrder()
            ->take($this->jml_display)
            ->get()
            ->map(function ($video) use ($user) {
                $video->thumb = $this->getGoogleDriveThumbnail($video->url);
                $video->isOwner = $user && $user->channels->contains('id', $video->channel->id);
                return $video;
            });
    }



    public function render()
    {
        $user = Auth::user();
        $isSubscribed = $user && $user->subscribed;
        return view('livewire.component.content-video-dashboard', [
            'contentVideos' => $this->contentVideos,
            'isSubscribed' => $isSubscribed,
        ]);
    }
}
