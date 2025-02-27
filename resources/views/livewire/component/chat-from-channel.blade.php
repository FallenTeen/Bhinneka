<div class="bg-white shadow-lg mx-4 my-8 rounded-lg flex flex-col min-h-[70vh]">
    <!-- Chat Type Selector -->
    <div class="flex border-b border-gray-300 bg-gray-100">
        <button wire:click="setChatType('all')"
            class="px-4 py-2 font-medium text-gray-700 border-b-2 {{ $chatType === 'all' ? 'border-ungumain text-ungumain' : 'border-transparent' }}">
            All Chats
        </button>
        <button wire:click="setChatType('regular')"
            class="px-4 py-2 font-medium text-gray-700 border-b-2 {{ $chatType === 'regular' ? 'border-ungumain text-ungumain' : 'border-transparent' }}">
            Regular Users
        </button>
        <button wire:click="setChatType('investors')"
            class="px-4 py-2 font-medium text-gray-700 border-b-2 {{ $chatType === 'investors' ? 'border-ungumain text-ungumain' : 'border-transparent' }}">
            Investors
        </button>
    </div>

    <div class="flex flex-row flex-1">
        <!-- USER LIST SIDEBAR -->
        <div class="w-1/4 border-r border-gray-300 flex flex-col">
            <!-- Search for Investors - Only shown when on Investors tab -->
            @if($chatType === 'investors')
                <div class="p-3 border-b border-gray-200">
                    <div class="relative">
                        <input type="text" wire:model.debounce.500ms="searchQuery" wire:keydown.enter="searchInvestors"
                            placeholder="Search for investors..."
                            class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-1 focus:ring-ungumain">
                        <button wire:click="searchInvestors"
                            class="absolute right-2 top-2 text-gray-500 hover:text-ungumain">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>

                    <!-- Search Results -->
                    @if(!empty($searchResults))
                        <div class="mt-2 border rounded shadow-sm bg-white">
                            <div class="p-2 border-b bg-gray-50 text-sm font-medium">Search Results</div>
                            @forelse($searchResults as $result)
                                <div class="p-2 border-b hover:bg-gray-50 flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-semibold text-yellow-600">{{ $result['initials'] }}</span>
                                        </div>
                                        <div class="ml-2">
                                            <div class="font-medium">{{ $result['name'] }}</div>
                                            @if($result['company_name'])
                                                <div class="text-xs text-gray-500">{{ $result['company_name'] }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    @if($result['already_in_chat'])
                                        <button wire:click="selectUser({{ $result['id'] }})"
                                            class="text-xs px-2 py-1 bg-gray-100 text-gray-700 rounded border">
                                            Open Chat
                                        </button>
                                    @else
                                        <button wire:click="startNewChat({{ $result['id'] }})"
                                            class="text-xs px-2 py-1 bg-ungumain text-white rounded">
                                            Start Chat
                                        </button>
                                    @endif
                                </div>
                            @empty
                                <div class="p-3 text-sm text-gray-500 text-center">
                                    No investors found
                                </div>
                            @endforelse
                        </div>
                    @endif
                </div>
            @endif

            <div class="overflow-y-auto flex-1">
                <div class="p-3 font-bold text-lg border-b">
                    {{ $chatType === 'investors' ? 'Investors' : ($chatType === 'regular' ? 'Regular Users' : 'All Contacts') }}
                </div>

                <!-- User List -->
                @forelse($filteredUsers as $chatUser)
                    <div wire:click="selectUser({{ $chatUser['id'] }})"
                        class="flex px-4 py-3 border-b cursor-pointer hover:bg-gray-100 
                                    {{ isset($selectedUser) && $selectedUser->id === $chatUser['id'] ? 'bg-gray-100' : '' }}">
                        <div
                            class="relative w-12 h-12 {{ $chatUser['is_investor'] ? 'bg-yellow-100' : 'bg-blue-100' }} rounded-full flex items-center justify-center">
                            <span
                                class="text-lg font-semibold {{ $chatUser['is_investor'] ? 'text-yellow-600' : 'text-blue-600' }}">{{ $chatUser['initials'] }}</span>
                            @if($chatUser['unread_count'] > 0)
                                <div
                                    class="absolute -top-1 -right-1 h-5 w-5 bg-red-500 rounded-full flex items-center justify-center text-white text-xs">
                                    {{ $chatUser['unread_count'] }}
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-col ml-3 flex-1 overflow-hidden">
                            <div class="flex items-center">
                                <span class="font-semibold line-clamp-1">{{ $chatUser['name'] }}</span>
                                @if($chatUser['is_investor'])
                                    <span
                                        class="ml-1 px-1.5 py-0.5 bg-yellow-100 text-yellow-800 text-xs rounded-full">Investor</span>
                                @endif
                            </div>
                            @if($chatUser['company_name'])
                                <span class="text-xs text-gray-500">{{ $chatUser['company_name'] }}</span>
                            @endif
                            <span class="text-sm text-gray-500 line-clamp-1 mt-0.5">{{ $chatUser['last_message'] }}</span>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-gray-500 text-center">
                        <p>No conversations found</p>
                        @if($chatType === 'investors')
                            <p class="text-sm mt-1">Try searching for investors above</p>
                        @endif
                    </div>
                @endforelse
            </div>
        </div>

        <!-- CHAT AREA -->
        <div class="w-3/4 flex flex-col max-h-[70vh] bg-gray-100">
            @if($selectedUser)
                    <div class="p-4 bg-ungumain text-white flex justify-between items-center">
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 {{ $selectedUser->role_id == 2 ? 'bg-yellow-100' : 'bg-blue-100' }} rounded-full flex items-center justify-center mr-2">
                                <span
                                    class="text-md font-semibold {{ $selectedUser->role_id == 2 ? 'text-yellow-600' : 'text-blue-600' }}">
                                    {{ strtoupper(substr($selectedUser->name, 0, 2)) }}
                                </span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold">{{ $selectedUser->name }}</h3>
                                @if($selectedUser->role_id == 2)
                                                    @php
                                                        $investorProfile = $selectedUser->investors->first();
                                                        $companyName = $investorProfile ? $investorProfile->company_name : null;
                                                    @endphp

                                                    @if($companyName)
                                                        <p class="text-xs text-gray-200">{{ $companyName }}</p>
                                                    @endif
                                @endif
                            </div>

                            @if($selectedUser->role_id == 2)
                                <span class="ml-2 px-2 py-0.5 bg-yellow-300 text-yellow-800 text-xs rounded-full">Investor</span>
                            @endif
                        </div>
                    </div>

                    <!-- Message container -->
                    <div class="flex-1 overflow-y-auto p-4 space-y-3" id="messageContainer">
                        @forelse($messages as $msg)
                            <div class="mb-2 {{ $msg['is_mine'] ? 'text-right' : 'text-left' }}">
                                <p
                                    class="{{ $msg['is_mine'] ? 'bg-ungumain text-white' : 'bg-gray-200 text-gray-700' }} rounded-lg py-2 px-4 inline-block max-w-[70%] break-words">
                                    {{ $msg['message'] }}
                                </p>
                                <div class="text-xs text-gray-500 mt-1">{{ $msg['created_at'] }}</div>
                            </div>
                        @empty
                            <div class="flex items-center justify-center h-full">
                                <div class="text-center text-gray-500">
                                    <p>No messages yet</p>
                                    <p class="text-sm mt-1">Send a message to start the conversation</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <script>
                        document.addEventListener('livewire:initialized', () => {
                            const container = document.getElementById('messageContainer');

                            const scrollToBottom = () => {
                                if (container) {
                                    container.scrollTop = container.scrollHeight;
                                }
                            };
                            scrollToBottom();
                            @this.on('refreshMessages', () => {
                                setTimeout(scrollToBottom, 100);
                            });
                            @this.on('messageSent', () => {
                                setTimeout(scrollToBottom, 100);
                            });
                            const observer = new MutationObserver(scrollToBottom);
                            if (container) {
                                observer.observe(container, { childList: true, subtree: true });
                            }
                            if (typeof Echo !== 'undefined' && @json(isset($selectedUser) && isset($channel))) {
                                Echo.private(`chat.${@json($channel->id)}`)
                                    .listen('MessageSent', (e) => {
                                        if (e.message.sender_id === @json($selectedUser->id)) {
                                            setTimeout(scrollToBottom, 100);
                                        }
                                    });
                            }
                            @this.on('newMessageReceived', (data) => {
                                if (!@this.selectedUser || @this.selectedUser.id !== data.senderId) {
                                    const toast = document.createElement('div');
                                    toast.className = 'fixed bottom-4 right-4 bg-gray-800 text-white p-3 rounded-lg shadow-lg z-50 max-w-xs cursor-pointer';
                                    toast.innerHTML = `
                                    <div class="font-bold">${data.senderName}</div>
                                    <div class="text-sm text-gray-300 truncate">${data.message}</div>
                                `;
                                    document.body.appendChild(toast);
                                    toast.addEventListener('click', () => {
                                        @this.call('selectUser', data.senderId);
                                        toast.remove();
                                    });
                                    setTimeout(() => {
                                        toast.remove();
                                    }, 5000);
                                }
                            });
                        });
                    </script>
                    <div class="p-4 border-t flex">
                        <input type="text" wire:model.defer="message" wire:keydown.enter="sendMessage"
                            class="w-full px-3 py-2 border rounded-l-md focus:outline-none focus:ring-2 focus:ring-ungumain"
                            placeholder="Type a message">
                        <button wire:click="sendMessage"
                            class="bg-ungumain text-white px-4 py-2 rounded-r-md hover:bg-purple-700 transition duration-300">
                            Send
                        </button>
                    </div>
            @else
                <div class="flex-1 flex items-center justify-center text-gray-500 p-8">
                    <div class="text-center space-y-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <p class="text-xl font-medium">Start a Conversation</p>
                        <p class="text-gray-400">Select a user or investor from the list to start chatting</p>
                        @if($chatType === 'investors')
                            <p class="text-gray-400">You can also search for new investors to connect with</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>