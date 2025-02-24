<?php

namespace App\Livewire\Component;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\InvestorPost;

class InvestorPosts extends Component
{
    use WithPagination;

    public $investorId;
    public $showClosed = false;
    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'showClosed' => ['except' => false]
    ];

    public function mount($investorId)
    {
        $this->investorId = $investorId;
    }

    public function render()
    {
        $query = InvestorPost::where('investor_profile_id', $this->investorId)
            ->when(!$this->showClosed, fn($q) => $q->where('status', 'active'))
            ->when($this->search, fn($q) => $q->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('position', 'like', '%' . $this->search . '%')
                    ->orWhere('location', 'like', '%' . $this->search . '%');
            }))
            ->latest();

        return view('livewire.component.investor-posts', [
            'posts' => $query->paginate(5)
        ]);
    }

    public function toggleShowClosed()
    {
        $this->showClosed = !$this->showClosed;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}