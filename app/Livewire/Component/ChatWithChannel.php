<?php

namespace App\Livewire\Component;

use App\Events\MessageSent;
use App\Events\UserTyping;
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
    public $typingUsers = [];

    public function getListeners()
    {
        if (!$this->channel) {
            return [];
        }

        return [
            "echo-private:chat.{$this->channel->id},MessageSent" => 'handleMessageSent',
            "echo-private:chat.{$this->channel->id},UserTyping" => 'handleUserTyping',
            'refreshMessages' => '$refresh'
        ];
    }

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->channel = Channel::where('slug', $slug)->firstOrFail();
        $this->loadMessages();
        $this->dispatch('refreshMessages');
    }

    public function loadMessages()
    {
        $messages = $this->channel->messages()
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        $this->messages = $messages->map(function ($msg) {
            return [
                'id' => $msg->id,
                'sender_id' => $msg->sender_id,
                'message' => $msg->message,
                'sender_name' => $msg->sender->name,
                'created_at' => $msg->created_at,
                'read_at' => $msg->read_at,
                'is_mine' => $msg->sender_id === Auth::id()
            ];
        })->toArray();
    }

    public function handleMessageSent($payload)
    {
        if (is_string($payload)) {
            $payload = json_decode($payload, true);
        }

        if ($payload['sender_id'] !== Auth::id()) {
            $this->messages[] = [
                'id' => $payload['id'],
                'sender_id' => $payload['sender_id'],
                'message' => $payload['message'],
                'sender_name' => $payload['sender_name'],
                'created_at' => $payload['created_at'],
                'read_at' => $payload['read_at'],
                'is_mine' => false
            ];

            Message::where('id', $payload['id'])
                ->update(['read_at' => now()]);

            $this->dispatch('messageSent');
        }
    }

    public function sendMessage()
    {
        $this->validate([
            'message' => 'required|string|max:1000',
        ]);

        $newMessage = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $this->channel->user->id,
            'message' => $this->message,
            'channel_id' => $this->channel->id,
            'read_at' => null
        ]);

        $newMessage->load('sender');
        $messageData = [
            'id' => $newMessage->id,
            'sender_id' => Auth::id(),
            'message' => $this->message,
            'sender_name' => Auth::user()->name,
            'created_at' => now()->format('H:i'),
            'read_at' => null,
            'is_mine' => true
        ];

        $this->messages[] = $messageData;

        event(new MessageSent($newMessage));
        event(new UserTyping($this->channel->id, Auth::id(), Auth::user()->name, false));

        $this->message = '';
        $this->dispatch('messageSent');
    }
    public function handleUserTyping($payload)
    {
        if (is_string($payload)) {
            $payload = json_decode($payload, true);
        }

        if ($payload['userId'] !== Auth::id()) {
            if ($payload['isTyping']) {
                $this->typingUsers[$payload['userId']] = [
                    'name' => $payload['userName'],
                    'timestamp' => now()
                ];
            } else {
                unset($this->typingUsers[$payload['userId']]);
            }
        }
    }
    public function updatedMessage($value)
    {
        if ($this->channel) {
            $now = now();
            if (!isset($this->lastTypingEvent) || $now->diffInMilliseconds($this->lastTypingEvent) > 1000) {
                event(new UserTyping(
                    $this->channel->id,
                    Auth::id(),
                    Auth::user()->name,
                    !empty($value)
                ));
                $this->lastTypingEvent = $now;
            }
        }
    }

    public function dehydrate()
    {
        if ($this->channel) {
            event(new UserTyping(
                $this->channel->id,
                Auth::id(),
                Auth::user()->name,
                false
            ));
        }
    }

    public function render()
    {
        return view('livewire.component.chat-with-channel');
    }
}