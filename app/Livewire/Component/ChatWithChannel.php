<?php

namespace App\Livewire\Component;

use App\Models\Channel;
use App\Models\Message;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ChatWithChannel extends Component
{
    public $slug;
    public $channel;
    public $message = '';
    public $messages = [];


    protected $rules = [
        'message' => 'required|string|max:1000',
    ];

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->channel = Channel::where('slug', $slug)->firstOrFail();
        $messages = $this->channel->messages()->with('sender')->latest()->get();
        $this->messages = $messages->map(function ($msg) {
            return [
                'id' => $msg->id,
                'sender_id' => $msg->sender_id,
                'message' => $msg->message,
                'sender_name' => $msg->sender->name
            ];
        })->toArray();
    }

    public function sendMessage()
    {
        $this->validate();

        $newMessage = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $this->channel->user->id,
            'message' => $this->message,
            'channel_id' => $this->channel->id,
        ]);

        $newMessage->load('sender');
        array_unshift($this->messages, [
            'id' => $newMessage->id,
            'sender_id' => $newMessage->sender_id,
            'message' => $newMessage->message,
            'sender_name' => $newMessage->sender->name
        ]);

        $this->message = '';
    }

    public function render()
    {
        return view('livewire.component.chat-with-channel');
    }
}