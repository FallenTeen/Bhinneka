<?php

namespace App\Livewire\Component;

use Livewire\Component;

class ContentSearchbar extends Component
{
    public $search;

    public function updatedSearch()
    {
        $this->dispatch('updateSearch', $this->search);
    }
    public function render()
    {
        return view('livewire.component.content-searchbar');
    }
}
