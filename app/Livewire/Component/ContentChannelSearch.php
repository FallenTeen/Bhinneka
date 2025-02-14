<?php

namespace App\Livewire\Component;

use App\Models\Channel;
use Livewire\Component;

class ContentChannelSearch extends Component
{
    public $channels = [];
    public $search = '';
    public $jml_display = 4;

    protected $listeners = ['updateSearch' => 'setSearch'];

    public function setSearch($value)
    {
        $this->search = $value;
        $this->loadChannels();
    }

    public function loadMore()
    {
        $this->jml_display += 4;
        $this->loadChannels();
    }

    public function loadChannels()
    {
        $query = Channel::query();

        if ($this->search) {
            $query->where('channel_name', 'like', "%{$this->search}%")
                ->orWhere('deskripsi', 'like', "%{$this->search}%");
        }

        $this->channels = $query->take($this->jml_display)->get();
    }

    public function mount()
    {
        $this->loadChannels();
    }

    public function render()
    {
        return view('livewire.component.content-channel-search', [
            'channels' => $this->channels
        ]);
    }
}
