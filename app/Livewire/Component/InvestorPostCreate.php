<?php

namespace App\Livewire\Component;

use App\Models\InvestorPost;
use Livewire\Component;

class InvestorPostCreate extends Component
{
    public $title;
    public $description;
    public $position;
    public $location;
    public $employment_type;
    public $required_skills = [];
    public $salary_range_start;
    public $salary_range_end;
    public $deadline;
    public $contact_email;
    public $skill_search = '';
    public $available_skills = [
        'Digital Marketing' => [
            'SEO',
            'Social Media Marketing',
            'Content Marketing',
            'Email Marketing',
            'SEM',
            'Google Ads',
        ],
        'Programming' => [
            'PHP',
            'JavaScript',
            'Python',
            'Java',
            'Ruby',
            'C++',
            'Laravel',
            'React',
            'Vue.js',
            'Node.js',
        ],
        'Design' => [
            'UI Design',
            'UX Design',
            'Graphic Design',
            'Web Design',
            'Product Design',
            'Figma',
            'Adobe XD',
        ],
        'Business' => [
            'Business Development',
            'Sales',
            'Marketing',
            'Project Management',
            'Product Management',
            'Business Analysis',
        ],
        'Soft Skills' => [
            'Communication',
            'Leadership',
            'Problem Solving',
            'Team Work',
            'Time Management',
            'Critical Thinking',
        ]
    ];

    protected function rules()
    {
        return [
            'title' => 'required|min:5',
            'description' => 'required|min:20',
            'position' => 'required',
            'location' => 'required',
            'employment_type' => 'required',
            'required_skills' => 'required|array|min:1',
            'salary_range_start' => 'nullable|numeric',
            'salary_range_end' => 'nullable|numeric|gte:salary_range_start',
            'deadline' => 'nullable|date|after:today',
            'contact_email' => 'required|email'
        ];
    }

    public function addSkill($skill)
    {
        if (!empty($skill) && !in_array($skill, $this->required_skills)) {
            $this->required_skills[] = $skill;
        }
        $this->skill_search = '';
    }

    public function removeSkill($index)
    {
        unset($this->required_skills[$index]);
        $this->required_skills = array_values($this->required_skills);
    }

    public function getFilteredSkillsProperty()
    {
        if (empty($this->skill_search)) {
            return [];
        }

        $filtered = [];
        foreach ($this->available_skills as $category => $skills) {
            foreach ($skills as $skill) {
                if (stripos($skill, $this->skill_search) !== false) {
                    $filtered[] = [
                        'category' => $category,
                        'skill' => $skill
                    ];
                }
            }
        }
        return $filtered;
    }

    public function save()
    {
        $this->validate();
        $investor = auth()->user()->investors->first();

        InvestorPost::create([
            'investor_profile_id' => $investor->id,
            'title' => $this->title,
            'description' => $this->description,
            'position' => $this->position,
            'location' => $this->location,
            'employment_type' => $this->employment_type,
            'required_skills' => $this->required_skills,
            'salary_range_start' => $this->salary_range_start,
            'salary_range_end' => $this->salary_range_end,
            'deadline' => $this->deadline,
            'contact_email' => $this->contact_email ?? $investor->email,
        ]);

        session()->flash('message', 'Post berhasil dibuat.');
        return redirect()->route('investor.post.index');
    }

    public function render()
    {
        return view('livewire.component.investor-post-create');
    }
}