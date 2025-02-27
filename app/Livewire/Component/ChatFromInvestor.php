<?php

namespace App\Livewire\Component;

use App\Models\InvestorProfile;
use Livewire\Component;
use App\Models\User;
use App\Models\Message;
use App\Models\Channel;
use App\Events\MessageSent;
use App\Events\UserTyping;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatFromInvestor extends Component
{
    public $user;
    public $last_message = '';
    public $message = '';
    public $selectedUser;
    public $messages = [];
    public $allUsers = [];
    public $searchQuery = '';
    public $searchResults = [];
    public $chatType = 'all';
    public $currentChannelId = null;
    public $unreadMessagesCount = [];

    public function getListeners()
    {
        $listeners = [
            'echo:global-messages,MessageSent' => 'handleGlobalMessage',
            'userSelected' => 'selectUser',
            'refreshMessages' => '$refresh'
        ];
        if ($this->currentChannelId) {
            $listeners["echo-private:chat.{$this->currentChannelId},MessageSent"] = 'broadcastedMessageReceived';
        }

        return $listeners;
    }
    public function broadcastedMessageReceived($payload)
    {
        if (is_string($payload)) {
            $payload = json_decode($payload, true);
        }

        $senderId = $payload['sender_id'] ?? null;

        if ($senderId && $senderId !== Auth::id()) {
            if (!isset($this->unreadMessagesCount[$senderId])) {
                $this->unreadMessagesCount[$senderId] = 0;
            }
            $this->unreadMessagesCount[$senderId]++;
            if ($this->selectedUser && $senderId === $this->selectedUser->id) {
                $createdAt = isset($payload['created_at']) ?
                    $payload['created_at'] :
                    now()->format('H:i');
                $this->messages[] = [
                    'id' => $payload['id'] ?? 0,
                    'message' => $payload['message'] ?? '',
                    'is_mine' => false,
                    'is_unread' => true,
                    'created_at' => $createdAt
                ];
                if (isset($payload['id'])) {
                    Message::where('id', $payload['id'])
                        ->where('receiver_id', Auth::id())
                        ->whereNull('read_at')
                        ->update(['read_at' => now()]);
                }
                $this->unreadMessagesCount[$senderId] = 0;
            }
            $this->refreshLastMessage();
            $this->dispatch('$refresh');
            $this->dispatch('messageSent');
            $this->dispatch('newMessageReceived', [
                'senderId' => $senderId,
                'senderName' => $payload['sender_name'] ?? 'User',
                'message' => $payload['message'] ?? 'New message'
            ]);
        }
    }

    public function startPolling()
    {
        $this->enablePolling = true;
    }

    public function stopPolling()
    {
        $this->enablePolling = false;
    }
    public function pollForNewMessages()
    {
        if (!$this->enablePolling) {
            return;
        }
        $lastCheck = now()->subSeconds(10);

        $newMessages = Message::where('receiver_id', Auth::id())
            ->where('created_at', '>=', $lastCheck)
            ->whereNull('read_at')
            ->with('sender')
            ->get();

        if ($newMessages->isNotEmpty()) {
            $this->refreshLastMessage();
            if ($this->selectedUser) {
                $relevantMessages = $newMessages->where('sender_id', $this->selectedUser->id);
                if ($relevantMessages->isNotEmpty()) {
                    $this->loadMessages();
                }
            }
            foreach ($newMessages as $message) {
                $senderId = $message->sender_id;

                if (!isset($this->unreadMessagesCount[$senderId])) {
                    $this->unreadMessagesCount[$senderId] = 0;
                }
                $this->unreadMessagesCount[$senderId]++;
                $this->dispatch('newMessageReceived', [
                    'senderId' => $senderId,
                    'senderName' => $message->sender->name,
                    'message' => $message->message
                ]);
            }

            $this->dispatch('$refresh');
        }
    }

    public function handleGlobalMessage($payload)
    {
        logger("Global message received in ChatFromInvestor: ", [$payload]);

        if (is_string($payload)) {
            $payload = json_decode($payload, true);
        }
        $receiverId = $payload['receiver_id'] ?? null;
        $senderId = $payload['sender_id'] ?? null;
        if (!$senderId) {
            return;
        }
        $isForCurrentUser = $receiverId && $receiverId == Auth::id();
        $isFromCurrentUser = $senderId == Auth::id();

        if ($isForCurrentUser || $isFromCurrentUser) {
            $this->refreshLastMessage();
            if ($isForCurrentUser && !$isFromCurrentUser) {
                if (!isset($this->unreadMessagesCount[$senderId])) {
                    $this->unreadMessagesCount[$senderId] = 0;
                }
                $this->unreadMessagesCount[$senderId]++;
                $this->dispatch('newMessageReceived', [
                    'senderId' => $senderId,
                    'senderName' => $payload['sender_name'] ?? 'User',
                    'message' => $payload['message'] ?? 'New message'
                ]);
            }
            if (
                $this->selectedUser &&
                ($senderId == $this->selectedUser->id ||
                    ($receiverId && $receiverId == $this->selectedUser->id))
            ) {
                $this->loadMessages();
            }
            $this->dispatch('$refresh');
        }
    }
    public function mount()
    {
        $this->user = Auth::user();
        $this->loadAllUsers();
        $this->initializeUnreadCounts();
    }
    public function initializeUnreadCounts()
    {
        $unreadCounts = Message::where('receiver_id', Auth::id())
            ->whereNotNull('channel_id')
            ->whereNull('read_at')
            ->select('sender_id', DB::raw('count(*) as count'))
            ->groupBy('sender_id')
            ->get();

        foreach ($unreadCounts as $count) {
            $this->unreadMessagesCount[$count->sender_id] = $count->count;
        }
    }

    public function loadAllUsers()
    {
        $usersWithChannels = User::where('role_id', 3)
            ->whereHas('channels')
            ->with([
                'channels' => function ($query) {
                    $query->select('id', 'user_id', 'channel_name');
                }
            ])
            ->get();

        $messagePartners = Message::where(function ($query) {
            $query->where('sender_id', Auth::id())
                ->orWhere('receiver_id', Auth::id());
        })
            ->whereIn('receiver_id', $usersWithChannels->pluck('id'))
            ->orWhereIn('sender_id', $usersWithChannels->pluck('id'))
            ->select('sender_id', 'receiver_id')
            ->get();

        $messageUserIds = [];
        foreach ($messagePartners as $message) {
            if ($message->sender_id != Auth::id()) {
                $messageUserIds[] = $message->sender_id;
            }
            if ($message->receiver_id != Auth::id()) {
                $messageUserIds[] = $message->receiver_id;
            }
        }
        $messageUserIds = array_unique($messageUserIds);

        $usersWithChatHistory = collect($messageUserIds);

        $this->allUsers = $usersWithChannels->map(function ($user) use ($usersWithChatHistory) {
            $hasChatHistory = $usersWithChatHistory->contains($user->id);
            $channel = $user->channels->first();

            $lastMessage = null;
            $unreadCount = 0;

            if ($hasChatHistory) {
                $lastMessage = Message::where(function ($query) use ($user) {
                    $query->where(function ($q) use ($user) {
                        $q->where('sender_id', Auth::id())
                            ->where('receiver_id', $user->id);
                    })->orWhere(function ($q) use ($user) {
                        $q->where('sender_id', $user->id)
                            ->where('receiver_id', Auth::id());
                    });
                })
                    ->where('channel_id', $channel->id)
                    ->latest()
                    ->first();

                $unreadCount = Message::where('sender_id', $user->id)
                    ->where('receiver_id', Auth::id())
                    ->where('channel_id', $channel->id)
                    ->whereNull('read_at')
                    ->count();
            }

            return [
                'id' => $user->id,
                'name' => $user->name,
                'channel_id' => $channel->id,
                'channel_name' => $channel->channel_name,
                'initials' => strtoupper(substr($user->name, 0, 2)),
                'last_message' => $lastMessage ? $lastMessage->message : '',
                'last_message_time' => $lastMessage ? $lastMessage->created_at : null,
                'unread_count' => $unreadCount,
                'has_chat_history' => $hasChatHistory
            ];
        })->toArray();
        usort($this->allUsers, function ($a, $b) {
            if ($a['has_chat_history'] === $b['has_chat_history']) {
                if ($a['has_chat_history']) {
                    if (empty($a['last_message_time']) && empty($b['last_message_time'])) {
                        return strcmp($a['name'], $b['name']);
                    }
                    if (empty($a['last_message_time'])) {
                        return 1;
                    }
                    if (empty($b['last_message_time'])) {
                        return -1;
                    }
                    return strtotime($b['last_message_time']) - strtotime($a['last_message_time']);
                }
                return strcmp($a['name'], $b['name']);
            }
            return $a['has_chat_history'] ? -1 : 1;
        });
    }
    public function getFilteredUsers()
    {
        if ($this->chatType === 'all') {
            return $this->allUsers;
        } else if ($this->chatType === 'recent') {
            return array_filter($this->allUsers, function ($user) {
                return $user['has_chat_history'];
            });
        } else {
            return array_filter($this->allUsers, function ($user) {
                return !$user['has_chat_history'];
            });
        }
    }

    public function selectUser($userId)
    {
        $this->selectedUser = User::with('channels')->find($userId);
        if ($this->selectedUser && $this->selectedUser->channels->isNotEmpty()) {
            $channel = $this->selectedUser->channels->first();
            $oldChannelId = $this->currentChannelId;
            $this->currentChannelId = $channel->id;

            if ($oldChannelId !== $this->currentChannelId) {
                $this->dispatch('echo:reconnect');
            }
            if (isset($this->unreadMessagesCount[$userId])) {
                $this->unreadMessagesCount[$userId] = 0;
            }
        }
        $this->loadMessages();
    }
    public function loadMessages()
    {
        if (!$this->selectedUser) {
            return;
        }

        $channel = $this->selectedUser->channels->first();
        if (!$channel) {
            return;
        }

        $this->currentChannelId = $channel->id;
        Message::where('channel_id', $channel->id)
            ->where('sender_id', $this->selectedUser->id)
            ->where('receiver_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $messages = Message::where('channel_id', $channel->id)
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->where('sender_id', Auth::id())
                        ->where('receiver_id', $this->selectedUser->id);
                })->orWhere(function ($q) {
                    $q->where('sender_id', $this->selectedUser->id)
                        ->where('receiver_id', Auth::id());
                });
            })
            ->orderBy('created_at', 'asc')
            ->get();

        $this->messages = $messages->map(function ($message) {
            return [
                'id' => $message->id,
                'message' => $message->message,
                'is_mine' => $message->sender_id === Auth::id(),
                'is_unread' => is_null($message->read_at),
                'created_at' => $message->created_at->format('H:i')
            ];
        })->toArray();
        $this->refreshLastMessage();
        $this->dispatch('refreshMessages');
    }

    public function sendMessage()
    {
        if (!$this->selectedUser || !trim($this->message)) {
            return;
        }

        $channel = $this->selectedUser->channels->first();
        if (!$channel) {
            return;
        }

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $this->selectedUser->id,
            'channel_id' => $channel->id,
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
        event(new UserTyping($channel->id, Auth::id(), Auth::user()->name, false));

        $this->message = '';
        $this->refreshLastMessage();
        $this->dispatch('messageSent');
    }

    public function refreshMessages()
    {
        $this->loadMessages();
    }

    public function refreshLastMessage()
    {
        $this->loadAllUsers();
        $this->dispatch('$refresh');
    }

    public function setChatType($type)
    {
        $this->chatType = $type;
        $this->searchResults = [];
        $this->searchQuery = '';
    }

    public function searchChannelOwners()
    {
        if (empty($this->searchQuery)) {
            $this->searchResults = [];
            return;
        }
        $this->searchResults = User::where('role_id', 3)
            ->whereHas('channels')
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->searchQuery . '%')
                    ->orWhereHas('channels', function ($q) {
                        $q->where('channel_name', 'like', '%' . $this->searchQuery . '%');
                    });
            })
            ->with([
                'channels' => function ($query) {
                    $query->select('id', 'user_id', 'channel_name');
                }
            ])
            ->limit(10)
            ->get()
            ->map(function ($user) {
                $channel = $user->channels->first();
                $alreadyInChat = collect($this->allUsers)->contains(function ($chatUser) use ($user) {
                    return $chatUser['id'] === $user->id;
                });

                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'initials' => strtoupper(substr($user->name, 0, 2)),
                    'channel_name' => $channel ? $channel->channel_name : null,
                    'already_in_chat' => $alreadyInChat
                ];
            })
            ->toArray();
    }

    public function startNewChat($userId)
    {
        $this->selectedUser = User::with('channels')->find($userId);
        if ($this->selectedUser && $this->selectedUser->channels->isNotEmpty()) {
            $channel = $this->selectedUser->channels->first();
            $this->currentChannelId = $channel->id;
        }
        $this->messages = [];
        $exists = collect($this->allUsers)->contains(function ($user) use ($userId) {
            return $user['id'] == $userId;
        });

        if (!$exists && $this->selectedUser) {
            $channel = $this->selectedUser->channels->first();

            $this->allUsers[] = [
                'id' => $this->selectedUser->id,
                'name' => $this->selectedUser->name,
                'channel_id' => $channel->id,
                'channel_name' => $channel->channel_name,
                'initials' => strtoupper(substr($this->selectedUser->name, 0, 2)),
                'last_message' => '',
                'last_message_time' => null,
                'unread_count' => 0,
                'has_chat_history' => false
            ];
        }

        $this->searchResults = [];
        $this->searchQuery = '';
    }

    public function render()
    {
        return view('livewire.component.chat-from-investor', [
            'filteredUsers' => $this->getFilteredUsers(),
            'unreadMessagesCount' => $this->unreadMessagesCount
        ]);
    }
}