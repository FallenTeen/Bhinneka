<?php

namespace App\Livewire\Component;

use Livewire\Component;
use App\Models\InvestorPost;
use App\Models\InvestorProfile;

class InvestorPostShow extends Component
{
    public $post;
    public $relatedPosts = [];
    public $investorProfile;

    public function mount($id)
    {
        $this->post = InvestorPost::findOrFail($id);
        if ($this->post->investor) {
            $this->investorProfile = $this->post->investor;
        }
        $this->relatedPosts = InvestorPost::where('id', '!=', $this->post->id)
            ->where(function ($query) {
                $query->where('location', $this->post->location);
                if (!empty($this->post->required_skills)) {
                    foreach ($this->post->required_skills as $skill) {
                        $query->orWhereJsonContains('required_skills', $skill);
                    }
                }
            })
            ->where('status', 'Open')
            ->limit(3)
            ->get();
    }

    public function render()
    {
        return view('livewire.component.investor-post-show');
    }
}