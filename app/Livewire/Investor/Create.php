<?php

namespace App\Livewire\Investor;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\InvestorProfile;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Create extends Component
{
    use WithFileUploads;

    public $company_name;
    public $description;
    public $investment_range;
    public $website;
    public $avatar;
    public $investment_interest = [];
    public $terms_agreement = false;
    public $captcha;
    public $document1; // Dokumen perusahaan

    protected $rules = [
        'company_name' => 'required|string|max:255',
        'description' => 'required|string',
        'investment_range' => 'required|string',
        'website' => 'nullable|url',
        'avatar' => 'nullable|image|max:2048',
        'investment_interest' => 'required|array|min:1',
        'terms_agreement' => 'accepted',
        'captcha' => 'nullable|captcha',
        'document1' => 'required|mimes:pdf|max:5120',
    ];

    public function refreshCaptcha()
    {
        $this->dispatch('refreshCaptcha');
    }

    public function toggleInterest($interest)
    {
        if (in_array($interest, $this->investment_interest)) {
            $index = array_search($interest, $this->investment_interest);
            unset($this->investment_interest[$index]);
            $this->investment_interest = array_values($this->investment_interest); // Reset indeks array
        } else {
            $this->investment_interest[] = $interest;
        }
    }

    public function save()
    {
        $this->validate();

        $avatarPath = null;
        if ($this->avatar) {
            $avatarName = Str::slug($this->company_name) . '.' . $this->avatar->getClientOriginalExtension();
            $avatarPath = $this->avatar->storeAs('investor_avatars', $avatarName, 'public');
        }

        $investor = InvestorProfile::create([
            'user_id' => Auth::id(),
            'company_name' => $this->company_name,
            'description' => $this->description,
            'investment_range' => $this->investment_range,
            'website' => $this->website,
            'avatar' => $avatarPath,
            'investment_interest' => $this->investment_interest,
            'status' => 'pending',
            'verified' => false,
        ]);

        $this->storeRegistration($this->document1);

        return redirect()->route('waiting');
    }

    private function storeRegistration($document1)
    {
        $registration = Registration::create([
            'user_id' => Auth::id(),
            'registration_type' => 'Investor',
        ]);

        $fileName = Str::random(40) . '.pdf';
        $filePath = $document1->storeAs('investor_documents', $fileName, 'public');

        $registration->document1_path = $filePath;
        $registration->document1_name = $document1->getClientOriginalName();
        $registration->save();
    }

    public function render()
    {
        return view('livewire.investor.create')->layout('layouts.app');
    }
}