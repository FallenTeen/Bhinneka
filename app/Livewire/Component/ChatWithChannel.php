<?php

namespace App\Livewire\Component;

use App\Events\MessageSent;
use App\Models\Channel;
use App\Models\Message;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

class ChatWithChannel extends Component
{
    public $slug;
    public $channel;
    public $message = '';
    public $messages = [];
    public $isChatboxOpen = false;

    protected $rules = [
        'message' => 'required|string|max:1000',
    ];

    public function getListeners()
    {
        if ($this->channel) {
            return [
                "echo-private:chat.{$this->channel->id},MessageSent" => 'handleNewMessage',
            ];
        }
        return [];
    }

    #[On('newMessage')]
    #[On('messageSent')]
    public function loadMessages()
    {
        $userId = Auth::id();

        $messages = $this->channel->messages()
            ->where(function ($query) use ($userId) {
                $query->where('sender_id', $userId)
                    ->orWhere('receiver_id', $userId);
            })
            ->with('sender')
            ->latest()
            ->get()
            ->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'sender_id' => $msg->sender_id,
                    'receiver_id' => $msg->receiver_id,
                    'message' => $msg->message,
                    'sender_name' => $msg->sender->name,
                    'created_at' => $msg->created_at
                ];
            })
            ->toArray();

        $this->messages = array_reverse($messages);
    }

    public function handleNewMessage($event)
    {
        \Log::info('Channel received message:', $event);

        $this->messages[] = [
            'id' => $event['id'],
            'sender_id' => $event['sender_id'],
            'message' => $event['message'],
            'sender_name' => $event['sender_name'],
            'created_at' => $event['created_at']
        ];

        $this->loadMessages();
    }

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->channel = Channel::where('slug', $slug)->firstOrFail();
        $this->loadMessages();
    }

    public function sendMessage()
    {
        if (empty(trim($this->message))) {
            return;
        }

        $this->validate();

        $newMessage = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $this->channel->user->id,
            'message' => $this->message,
            'channel_id' => $this->channel->id,
        ]);

        $newMessage->load('sender');
        broadcast(new MessageSent($newMessage))->toOthers();
        $this->messages[] = [
            'id' => $newMessage->id,
            'sender_id' => $newMessage->sender_id,
            'message' => $newMessage->message,
            'sender_name' => $newMessage->sender->name,
            'created_at' => $newMessage->created_at
        ];

        $this->message = '';
        $this->dispatch('messageSent');
    }

    public function render()
    {
        return view('livewire.component.chat-with-channel');
    }
}