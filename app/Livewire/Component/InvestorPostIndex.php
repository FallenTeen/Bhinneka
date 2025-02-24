<?php

namespace App\Livewire\Component;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\InvestorPost;
use Illuminate\Support\Facades\Auth;

class InvestorPostIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $employmentFilter = '';
    public $sortBy = 'latest';
    public $editingPost = null;
    public $skill_search = '';
    public $required_skills = [];

    protected $rules = [
        'editingPost.title' => 'required|min:3',
        'editingPost.description' => 'required',
        'editingPost.position' => 'required',
        'editingPost.location' => 'required',
        'editingPost.employment_type' => 'required',
        'editingPost.salary_range_start' => 'required|numeric|min:0',
        'editingPost.salary_range_end' => 'required|numeric|gt:editingPost.salary_range_start',
        'editingPost.deadline' => 'required|date|after:today',
        'editingPost.contact_email' => 'required|email',
    ];

    public function mount()
    {
        $this->required_skills = collect([]);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function editPost($postId)
    {
        $post = InvestorPost::findOrFail($postId);
        $this->editingPost = $post->toArray();
        $this->required_skills = collect($post->required_skills);
    }

    public function addSkill()
    {
        if (!empty($this->skill_search) && !$this->required_skills->contains($this->skill_search)) {
            $this->required_skills->push($this->skill_search);
            $this->skill_search = '';
        }
    }

    public function removeSkill($index)
    {
        $this->required_skills = $this->required_skills->except($index)->values();
    }

    public function updatePost()
    {
        $this->validate();

        $post = InvestorPost::find($this->editingPost['id']);

        if ($post) {
            $post->update([
                'title' => $this->editingPost['title'],
                'description' => $this->editingPost['description'],
                'position' => $this->editingPost['position'],
                'location' => $this->editingPost['location'],
                'employment_type' => $this->editingPost['employment_type'],
                'salary_range_start' => $this->editingPost['salary_range_start'],
                'salary_range_end' => $this->editingPost['salary_range_end'],
                'deadline' => $this->editingPost['deadline'],
                'contact_email' => $this->editingPost['contact_email'],
                'required_skills' => $this->required_skills->toArray(),
            ]);

            session()->flash('message', 'Post berhasil diperbarui.');
            $this->editingPost = null;
        }
    }

    public function deletePost($postId)
    {
        $post = InvestorPost::find($postId);
        if ($post) {
            $post->delete();
            session()->flash('message', 'Post berhasil dihapus.');
        }
    }

    public function closePost()
    {
        if ($this->editingPost) {
            $post = InvestorPost::find($this->editingPost['id']);
            if ($post) {
                $post->update(['status' => 'closed']);
                session()->flash('message', 'Post berhasil ditutup.');
                $this->editingPost = null;
            }
        }
    }

    public function render()
    {
        $query = InvestorPost::query();
        $investorProfileId = Auth::user()->investors->first()->id;
        $query->where('investor_profile_id', $investorProfileId);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('position', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->employmentFilter) {
            $query->where('employment_type', $this->employmentFilter);
        }

        switch ($this->sortBy) {
            case 'deadline':
                $query->orderBy('deadline', 'asc');
                break;
            case 'salary_high':
                $query->orderBy('salary_range_end', 'desc');
                break;
            case 'salary_low':
                $query->orderBy('salary_range_start', 'asc');
                break;
            default:
                $query->latest();
                break;
        }

        return view('livewire.component.investor-post-index', [
            'posts' => $query->paginate(10)
        ]);
    }
}