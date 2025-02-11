<?php

namespace App\Livewire\Channel;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Channel;

class Create extends Component
{
    use WithFileUploads;

    public $channel_name, $slug, $deskripsi, $avatar, $exlink = [], $terms_agreement = false, $captcha;

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

        return redirect()->route('user.channel');
    }
    public function render()
    {
        return view('livewire.channel.create')->layout('layouts.app');
    }
}
