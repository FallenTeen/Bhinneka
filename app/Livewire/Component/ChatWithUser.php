<?php

namespace App\Livewire\Component;

use Livewire\Component;
use App\Models\User;
use App\Models\Message;
use App\Models\Channel;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Broadcast;

class ChatWithUser extends Component
{
    public $user;
    public $selectedUser;
    public $message = '';
    public $messages = [];
    public $users = [];
    public $channel;

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

    public function handleNewMessage($event)
    {
        if (
            $this->selectedUser &&
            ($event['sender_id'] === $this->selectedUser->id || $event['receiver_id'] === $this->selectedUser->id)
        ) {
            $this->messages[] = [
                'id' => $event['id'],
                'message' => $event['message'],
                'is_mine' => $event['sender_id'] === auth()->id(),
                'created_at' => $event['created_at'],
                'read_at' => null
            ];

            if ($event['sender_id'] === $this->selectedUser->id) {
                Message::where('id', $event['id'])->update(['read_at' => now()]);
            }

            $this->loadMessages();
            $this->loadUsers();
        } else {
            $this->loadUsers();
        }
    }

    public function mount()
    {
        $this->channel = Channel::where('user_id', Auth::id())->first();
        $this->loadUsers();
    }

    #[On('messageSent')]
    public function loadUsers()
    {
        $userIds = Message::where('channel_id', $this->channel->id)
            ->where(function ($query) {
                $query->where('sender_id', '!=', Auth::id())
                    ->orWhere('receiver_id', '!=', Auth::id());
            })
            ->pluck('sender_id')
            ->merge(Message::where('channel_id', $this->channel->id)
                ->pluck('receiver_id'))
            ->unique()
            ->filter(function ($id) {
                return $id !== Auth::id();
            });

        $this->users = User::whereIn('id', $userIds)
            ->get()
            ->map(function ($user) {
                $lastMessage = Message::where('channel_id', $this->channel->id)
                    ->where(function ($query) use ($user) {
                        $query->where(function ($q) use ($user) {
                            $q->where('sender_id', $user->id)
                                ->where('receiver_id', Auth::id());
                        })->orWhere(function ($q) use ($user) {
                            $q->where('sender_id', Auth::id())
                                ->where('receiver_id', $user->id);
                        });
                    })
                    ->latest()
                    ->first();

                $unreadCount = Message::where('channel_id', $this->channel->id)
                    ->where('sender_id', $user->id)
                    ->where('receiver_id', Auth::id())
                    ->whereNull('read_at')
                    ->count();

                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'initials' => strtoupper(substr($user->name, 0, 2)),
                    'last_message' => $lastMessage?->message ?? '',
                    'last_message_time' => $lastMessage?->created_at ?? null,
                    'unread_count' => $unreadCount
                ];
            })
            ->sortByDesc('last_message_time')
            ->values()
            ->toArray();
    }

    public function selectUser($userId)
    {
        $this->selectedUser = User::find($userId);
        Message::where('channel_id', $this->channel->id)
            ->where('sender_id', $userId)
            ->where('receiver_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $this->loadMessages();
        $this->loadUsers();
        $this->dispatch('userSelected');
    }

    #[On('messageSent')]
    public function loadMessages()
    {
        if (!$this->selectedUser) {
            $this->messages = [];
            return;
        }

        $this->messages = Message::where('channel_id', $this->channel->id)
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->where('sender_id', $this->selectedUser->id)
                        ->where('receiver_id', Auth::id());
                })->orWhere(function ($q) {
                    $q->where('sender_id', Auth::id())
                        ->where('receiver_id', $this->selectedUser->id);
                });
            })
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($message) {
                return [
                    'id' => $message->id,
                    'message' => $message->message,
                    'is_mine' => $message->sender_id === Auth::id(),
                    'created_at' => $message->created_at,
                    'read_at' => $message->read_at
                ];
            })
            ->toArray();
    }


    public function sendMessage()
    {
        if (!$this->selectedUser || !trim($this->message)) {
            return;
        }

        $this->validate();

        $newMessage = Message::create([
            'channel_id' => $this->channel->id,
            'sender_id' => Auth::id(),
            'receiver_id' => $this->selectedUser->id,
            'message' => $this->message,
            'created_at' => now(),
        ]);

        // Use only one broadcast method
        broadcast(new MessageSent($newMessage))->toOthers();

        $this->messages[] = [
            'id' => $newMessage->id,
            'message' => $newMessage->message,
            'is_mine' => true,
            'created_at' => $newMessage->created_at,
            'read_at' => null
        ];

        $this->message = '';
        $this->loadMessages();
        $this->loadUsers();
        $this->dispatch('messageSent');
    }

    public function render()
    {
        return view('livewire.component.chat-with-user');
    }
}