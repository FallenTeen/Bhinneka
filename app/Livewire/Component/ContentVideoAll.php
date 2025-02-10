<?php

namespace App\Livewire\Component;

use Livewire\Component;
use App\Models\ContentVideo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class ContentVideoAll extends Component
{
    protected $listeners = ['updateSearch' => 'setSearch'];
    public $contentVideos, $jml_display = 4, $search = '';

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

    public function setSearch($value)
    {
        $this->search = $value;
        $this->mount();
    }
    public function updatingSearch()
    {
        $this->mount();
    }
    public function loadMore()
    {
        $this->jml_display += 4;
        $this->mount();
    }

    // public function mount()
    // {
    //     $this->contentVideos = ContentVideo::with('channel')
    //         ->inRandomOrder()
    //         ->take($this->jml_display)
    //         ->get()
    //         ->map(function ($video) {
    //             $video->thumb = $this->getGoogleDriveThumbnail($video->url);
    //             return $video;
    //         });
    // }


    public function mount()
    {
        $query = ContentVideo::with('channel');

        if ($this->search) {
            $query->where('judul', 'like', "%{$this->search}%")
                ->orWhereHas('channel', function ($q) {
                    $q->where('channel_name', 'like', "%{$this->search}%")
                        ->orWhereHas('user', function ($q) {
                            $q->where('name', 'like', "%{$this->search}%");
                        });
                });
        }

        $this->contentVideos = $query->inRandomOrder()
            ->take($this->jml_display)
            ->get()
            ->map(function ($video) {
                $video->thumb = $this->getGoogleDriveThumbnail($video->url);
                return $video;
            });
    }
    public function render()
    {
        $user = Auth::user();
        $isSubscribed = $user && $user->subscribed;
        return view('livewire.component.content-video-all', [
            'contentVideos' => $this->contentVideos,
            'isSubscribed' => $isSubscribed,
        ]);
    }
}
