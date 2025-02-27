<?php

namespace App\Livewire\Component;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\InvestorPost;

class Allinvestorposts extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $posts = InvestorPost::query()
            ->when($this->search, function ($query) {
                return $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('position', 'like', '%' . $this->search . '%')
                        ->orWhere('location', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterStatus, function ($query) {
                return $query->where('status', $this->filterStatus);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $statuses = InvestorPost::distinct()->pluck('status');

        return view('livewire.component.allinvestorposts', [
            'posts' => $posts,
            'statuses' => $statuses,
        ]);
    }
}