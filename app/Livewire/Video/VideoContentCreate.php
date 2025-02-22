<?php

namespace App\Livewire\Video;

use Livewire\Component;
use App\Models\ContentVideo;
use Illuminate\Support\Str;

class VideoContentCreate extends Component
{
    public $judul, $slug, $deskripsi, $url, $is_exclusive = false;

    protected $rules = [
        'judul' => 'required|string|max:255',
        'slug' => 'required|string|unique:content_videos,slug',
        'deskripsi' => 'nullable|string',
        'url' => 'required|url|regex:/^https:\/\/drive\.google\.com\/.*$/',
        'is_exclusive' => 'boolean',
    ];

    private function convertToPreviewUrl($url)
    {
        if (preg_match('/https:\/\/drive\.google\.com\/file\/d\/(.*?)(\/|$)/', $url, $matches)) {
            return "https://drive.google.com/file/d/{$matches[1]}/preview";
        }
        return $url;
    }

    public function save()
    {
        if (!$this->slug) {
            $this->slug = Str::slug($this->judul);
        }

        $this->validate();

        $channel = auth()->user()->channels()->first();

        if (!$channel) {
            session()->flash('error', 'You need to have a channel to add a video.');
            return;
        }

        $this->url = $this->convertToPreviewUrl($this->url);
        ContentVideo::create([
            'channel_id' => $channel->id,
            'judul' => $this->judul,
            'slug' => $this->slug,
            'deskripsi' => $this->deskripsi,
            'url' => $this->url,
            'is_exclusive' => $this->is_exclusive,
        ]);

        session()->flash('message', 'Video berhasil ditambahkan!');
        return redirect()->route('creator.channel');
    }

    public function render()
    {
        return view('livewire.video.video-content-create')->layout('layouts.app');
    }
}
