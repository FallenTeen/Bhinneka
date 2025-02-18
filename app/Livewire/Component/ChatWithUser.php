<?php

namespace App\Livewire\Component;

use Livewire\Component;
use App\Models\User;
use App\Models\Message;
use App\Models\Channel;
use Illuminate\Support\Facades\Auth;

class ChatWithUser extends Component
{
    public $user;
    public $message = '';
    public $selectedUser;
    public $messages = [];
    public $users = [];
    public $channel;


    public function mount()
    {
        $this->channel = Channel::where('user_id', Auth::id())->first();

        $this->users = Message::where('channel_id', $this->channel->id)
            ->with('sender')
            ->select('sender_id')
            ->distinct()
            ->get()
            ->map(function ($message) {
                return [
                    'id' => $message->sender->id,
                    'name' => $message->sender->name,
                    'initials' => strtoupper(substr($message->sender->name, 0, 2)),
                    'last_message' => Message::where('sender_id', $message->sender_id)
                        ->where('channel_id', $this->channel->id)
                        ->latest()
                        ->first()?->message ?? ''
                ];
            })
            ->toArray();
    }

    public function selectUser($userId)
    {
        $this->selectedUser = User::find($userId);
        $this->loadMessages();
    }

    public function loadMessages()
    {
        if (!$this->selectedUser) {
            return;
        }

        $this->messages = Message::where('channel_id', $this->channel->id)
            ->where(function ($query) {
                $query->where('sender_id', $this->selectedUser->id)
                    ->orWhere('sender_id', Auth::id());
            })
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($message) {
                return [
                    'id' => $message->id,
                    'message' => $message->message,
                    'is_mine' => $message->sender_id === Auth::id()
                ];
            })
            ->toArray();
    }

    public function sendMessage()
    {
        if (!$this->selectedUser || !trim($this->message)) {
            return;
        }

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $this->selectedUser->id,
            'channel_id' => $this->channel->id,
            'message' => $this->message
        ]);

        $this->messages[] = [
            'id' => uniqid(),
            'message' => $this->message,
            'is_mine' => true
        ];

        $this->message = '';
    }

    public function render()
    {
        return view('livewire.component.chat-with-user');
    }
}