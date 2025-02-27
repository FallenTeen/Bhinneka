<?php

namespace App\Livewire\Component;

use Livewire\Component;
use App\Models\User;
use App\Models\Message;
use App\Models\Channel;
use App\Models\InvestorProfile;
use App\Events\MessageSent;
use App\Events\UserTyping;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatFromChannel extends Component
{
    public $user;
    public $last_message = '';
    public $message = '';
    public $selectedUser;
    public $messages = [];
    public $allUsers = [];
    public $channel;
    public $chatType = 'all';
    public $searchQuery = '';
    public $searchResults = [];
    public $unreadMessagesCount = [];

    public function getListeners()
    {
        if (!$this->channel) {
            return [];
        }
        return [
            "echo-private:chat.{$this->channel->id},MessageSent" => 'broadcastedMessageReceived',
            'refreshMessages' => '$refresh',
            'userSelected' => 'selectUser'
        ];
    }
    public function broadcastedMessageReceived($payload)
    {
        if (is_string($payload)) {
            $payload = json_decode($payload, true);
        }
        if ($payload['sender_id'] !== Auth::id()) {
            $senderId = $payload['sender_id'];
            if (!isset($this->unreadMessagesCount[$senderId])) {
                $this->unreadMessagesCount[$senderId] = 0;
            }
            $this->unreadMessagesCount[$senderId]++;
            if ($this->selectedUser && $senderId === $this->selectedUser->id) {
                $this->messages[] = [
                    'id' => $payload['id'],
                    'message' => $payload['message'],
                    'is_mine' => false,
                    'is_unread' => true,
                    'created_at' => $payload['created_at']
                ];
                Message::where('id', $payload['id'])
                    ->update(['read_at' => now()]);
                $this->unreadMessagesCount[$senderId] = 0;
                $this->dispatch('messageSent');
            }

            $this->refreshLastMessage();
            $this->dispatch('newMessageReceived', [
                'senderId' => $senderId,
                'senderName' => $payload['sender_name'],
                'message' => $payload['message']
            ]);
        }
    }

    public function mount()
    {
        $this->user = Auth::user();
        $this->channel = Channel::where('user_id', Auth::id())->first();
        $this->loadAllUsers();
        $this->initializeUnreadCounts();
    }

    public function initializeUnreadCounts()
    {
        $unreadCounts = Message::where('receiver_id', Auth::id())
            ->where('channel_id', $this->channel->id)
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
        $messagePartners = Message::where(function ($query) {
            $query->where('sender_id', Auth::id())
                ->orWhere('receiver_id', Auth::id());
        })
            ->where('channel_id', $this->channel->id)
            ->select('sender_id', 'receiver_id')
            ->get();

        $userIds = [];

        foreach ($messagePartners as $message) {
            if ($message->sender_id != Auth::id()) {
                $userIds[] = $message->sender_id;
            }
            if ($message->receiver_id != Auth::id()) {
                $userIds[] = $message->receiver_id;
            }
        }
        $userIds = array_unique($userIds);

        if (empty($userIds)) {
            $this->allUsers = [];
            return;
        }
        $users = User::whereIn('id', $userIds)
            ->with('role')
            ->get();

        $this->allUsers = $users->map(function ($user) {
            $lastMessage = Message::where(function ($query) use ($user) {
                $query->where(function ($q) use ($user) {
                    $q->where('sender_id', Auth::id())
                        ->where('receiver_id', $user->id);
                })->orWhere(function ($q) use ($user) {
                    $q->where('sender_id', $user->id)
                        ->where('receiver_id', Auth::id());
                });
            })
                ->where('channel_id', $this->channel->id)
                ->latest()
                ->first();

            $unreadCount = Message::where('sender_id', $user->id)
                ->where('receiver_id', Auth::id())
                ->where('channel_id', $this->channel->id)
                ->whereNull('read_at')
                ->count();
            $isInvestor = $user->role_id == 2;
            $investorProfile = null;
            if ($isInvestor) {
                $investorProfile = InvestorProfile::where('user_id', $user->id)->first();
            }

            return [
                'id' => $user->id,
                'name' => $user->name,
                'role_id' => $user->role_id,
                'role_name' => $user->role ? $user->role->role : 'User',
                'initials' => strtoupper(substr($user->name, 0, 2)),
                'last_message' => $lastMessage ? $lastMessage->message : '',
                'last_message_time' => $lastMessage ? $lastMessage->created_at : null,
                'unread_count' => $unreadCount,
                'is_investor' => $isInvestor,
                'company_name' => $investorProfile ? $investorProfile->company_name : null
            ];
        })->toArray();
        usort($this->allUsers, function ($a, $b) {
            if (empty($a['last_message_time']) && empty($b['last_message_time'])) {
                return 0;
            }
            if (empty($a['last_message_time'])) {
                return 1;
            }
            if (empty($b['last_message_time'])) {
                return -1;
            }
            return strtotime($b['last_message_time']) - strtotime($a['last_message_time']);
        });
    }

    public function getFilteredUsers()
    {
        if ($this->chatType === 'all') {
            return $this->allUsers;
        } else if ($this->chatType === 'investors') {
            return array_filter($this->allUsers, function ($user) {
                return $user['is_investor'];
            });
        } else {
            return array_filter($this->allUsers, function ($user) {
                return !$user['is_investor'];
            });
        }
    }

    public function selectUser($userId)
    {
        $this->selectedUser = User::find($userId);
        $this->loadMessages();

        // Reset unread
        if (isset($this->unreadMessagesCount[$userId])) {
            $this->unreadMessagesCount[$userId] = 0;
        }
    }

    public function loadMessages()
    {
        if (!$this->selectedUser) {
            return;
        }

        // ALL MARKERZZZ
        Message::where('channel_id', $this->channel->id)
            ->where('sender_id', $this->selectedUser->id)
            ->where('receiver_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $messages = Message::where('channel_id', $this->channel->id)
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
    }

    public function setChatType($type)
    {
        $this->chatType = $type;
        $this->searchResults = [];
        $this->searchQuery = '';
    }

    public function searchInvestors()
    {
        if (empty($this->searchQuery)) {
            $this->searchResults = [];
            return;
        }
        $this->searchResults = User::where('role_id', 2)
            ->where('name', 'like', '%' . $this->searchQuery . '%')
            ->with('investors')
            ->limit(10)
            ->get()
            ->map(function ($investor) {
                $alreadyInChat = collect($this->allUsers)->contains(function ($user) use ($investor) {
                    return $user['id'] === $investor->id;
                });

                $investorProfile = $investor->investors->first();

                return [
                    'id' => $investor->id,
                    'name' => $investor->name,
                    'initials' => strtoupper(substr($investor->name, 0, 2)),
                    'company_name' => $investorProfile ? $investorProfile->company_name : null,
                    'already_in_chat' => $alreadyInChat
                ];
            })
            ->toArray();
    }

    public function startNewChat($userId)
    {
        $this->selectedUser = User::find($userId);
        $this->messages = [];
        $exists = collect($this->allUsers)->contains(function ($user) use ($userId) {
            return $user['id'] == $userId;
        });

        if (!$exists) {
            $user = User::with('role', 'investors')->find($userId);
            $isInvestor = $user->role_id == 2;
            $investorProfile = $isInvestor ? $user->investors->first() : null;

            $this->allUsers[] = [
                'id' => $user->id,
                'name' => $user->name,
                'role_id' => $user->role_id,
                'role_name' => $user->role ? $user->role->role : 'User',
                'initials' => strtoupper(substr($user->name, 0, 2)),
                'last_message' => '',
                'last_message_time' => null,
                'unread_count' => 0,
                'is_investor' => $isInvestor,
                'company_name' => $investorProfile ? $investorProfile->company_name : null
            ];
        }

        $this->searchResults = [];
        $this->searchQuery = '';
    }

    public function render()
    {
        return view('livewire.component.chat-from-channel', [
            'filteredUsers' => $this->getFilteredUsers(),
            'unreadMessagesCount' => $this->unreadMessagesCount
        ]);
    }
}