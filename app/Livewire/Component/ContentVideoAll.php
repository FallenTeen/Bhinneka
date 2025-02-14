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

    public function mount()
    {
        $user = Auth::user();
        $query = ContentVideo::with('channel')->where('show', true);

        if ($this->search) {
            $searchTerm = strtolower($this->search);

            $query->where(function ($query) use ($searchTerm) {
                $query->whereRaw('LOWER(judul) LIKE ?', ["%{$searchTerm}%"])
                    ->orWhereHas('channel', function ($q) use ($searchTerm) {
                        $q->whereRaw('LOWER(channel_name) LIKE ?', ["%{$searchTerm}%"])
                            ->orWhereHas('user', function ($q) use ($searchTerm) {
                                $q->whereRaw('LOWER(name) LIKE ?', ["%{$searchTerm}%"]);
                            });
                    });
            });
        }

        $this->contentVideos = $query->inRandomOrder()
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
        return view('livewire.component.content-video-all', [
            'contentVideos' => $this->contentVideos,
            'isSubscribed' => $isSubscribed,
        ]);
    }
}
