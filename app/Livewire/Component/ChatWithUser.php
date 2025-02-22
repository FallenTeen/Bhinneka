<?php

namespace App\Livewire\Component;

use Livewire\Component;
use App\Models\User;
use App\Models\Message;
use App\Models\Channel;
use App\Events\MessageSent;
use App\Events\UserTyping;
use Illuminate\Support\Facades\Auth;

class ChatWithUser extends Component
{
    public $user;
    public $last_message = '';
    public $message = '';
    public $selectedUser;
    public $messages = [];
    public $users = [];
    public $channel;


    public function getListeners()
    {
        if (!$this->channel) {
            return [];
        }

        return [
            "echo-private:chat.{$this->channel->id},MessageSent" => 'handleMessageSent',
            'refreshMessages' => '$refresh'
        ];
    }
    public function handleMessageSent($payload)
    {
        if (is_string($payload)) {
            $payload = json_decode($payload, true);
        }

        if ($this->selectedUser && $payload['sender_id'] === $this->selectedUser->id) {
            $this->messages[] = [
                'id' => $payload['id'],
                'message' => $payload['message'],
                'is_mine' => false,
                'is_unread' => true
            ];
            Message::where('id', $payload['id'])
                ->update(['read_at' => now()]);
            $this->refreshLastMessage();
            $this->dispatch('messageSent');
        }
    }
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
                        ->first()?->message ?? '',
                    'unread_count' => Message::where('receiver_id', Auth::id())
                        ->where('sender_id', $message->sender_id)
                        ->whereNull('read_at')
                        ->count()
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

        Message::where('channel_id', $this->channel->id)
            ->where('receiver_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

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
                    'is_mine' => $message->sender_id === Auth::id(),
                    'is_unread' => is_null($message->read_at)
                ];
            })
            ->toArray();
    }

    public function sendMessage()
    {
        if (!$this->selectedUser || !trim($this->message)) {
            return;
        }

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $this->selectedUser->id,
            'channel_id' => $this->channel->id,
            'message' => $this->message,
            'read_at' => null
        ]);

        $message->load('sender');

        $this->messages[] = [
            'id' => $message->id,
            'message' => $this->message,
            'is_mine' => true,
            'created_at' => now()->format('H:i')
        ];

        event(new MessageSent($message));
        event(new UserTyping($this->channel->id, Auth::id(), Auth::user()->name, false));

        $this->message = '';
    }

    public function refreshMessages()
    {
        $this->loadMessages();
    }
    public function refreshLastMessage()
    {
        foreach ($this->users as &$user) {
            $user['last_message'] = Message::where('sender_id', $user['id'])
                ->where('channel_id', $this->channel->id)
                ->latest()
                ->first()?->message ?? '';
        }
    }

    public function render()
    {
        return view('livewire.component.chat-with-user');
    }
}
