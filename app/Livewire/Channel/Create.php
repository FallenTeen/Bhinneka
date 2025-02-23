<?php

namespace App\Livewire\Channel;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Channel;
use App\Models\Registration;

class Create extends Component
{
    use WithFileUploads;

    public $channel_name, $slug, $deskripsi, $avatar, $exlink = [], $terms_agreement = false, $captcha;
    public $document1, $document2, $document3;

    public function updatedChannelName()
    {
        $this->slug = Str::slug($this->channel_name);
    }

    public function refreshCaptcha()
    {
        $this->dispatch('refreshCaptcha');
    }

    public function save()
    {
        $this->validate([
            'channel_name' => 'required|string|unique:channels,channel_name',
            'slug' => 'required|string|unique:channels,slug',
            'deskripsi' => 'nullable|string',
            'avatar' => 'nullable|image|max:2048',
            'captcha' => 'required|captcha',
            'terms_agreement' => 'accepted',
            'document1' => 'required|mimes:pdf,docx|max:2048',
            'document2' => 'nullable|mimes:pdf,docx|max:2048',
            'document3' => 'nullable|mimes:pdf,docx|max:2048',
        ]);

        $avatarPath = null;
        if ($this->avatar) {
            $avatarName = Str::slug($this->channel_name) . '.' . $this->avatar->getClientOriginalExtension();
            $avatarPath = $this->avatar->storeAs('avatarsimages', $avatarName, 'public');
        }

        Channel::create([
            'user_id' => Auth::id(),
            'channel_name' => $this->channel_name,
            'slug' => $this->slug,
            'deskripsi' => $this->deskripsi,
            'avatar' => $avatarPath,
            'exlink' => json_encode($this->exlink),
            'verified' => false,
        ]);
        $this->storeRegistration($this->document1, $this->document2, $this->document3);

        return redirect()->route('channel.waiting');
    }
    private function storeRegistration($document1, $document2, $document3)
    {
        $registration = Registration::create([
            'user_id' => Auth::id(),
            'registration_type' => 'channel_owner',
        ]);

        $this->storeDocument($registration, $document1, 'document1');
        $this->storeDocument($registration, $document2, 'document2');
        $this->storeDocument($registration, $document3, 'document3');
    }
    private function storeDocument(Registration $registration, $file, $attribute)
    {
        $fileName = Str::random(40) . '.pdf';
        $filePath = $file->storeAs('channel_documents', $fileName, 'public');

        $registration->{$attribute . '_path'} = $filePath;
        $registration->{$attribute . '_name'} = $file->getClientOriginalName();
        $registration->save();
    }

    public function render()
    {
        return view('livewire.channel.create')->layout('layouts.app');
    }
}