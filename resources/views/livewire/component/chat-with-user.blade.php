<div class="flex h-full bg-white rounded-lg shadow-xl overflow-hidden min-h-[80vh]">
    <!-- Users List -->
    <div class="w-1/3 border-r bg-gray-50">
        <div wire:poll.5s="loadUsers" class="p-4 space-y-2">
            @foreach($users as $user)
                <button wire:click="selectUser({{ $user['id'] }})" 
                    class="w-full text-left p-4 rounded-lg transition duration-300 transform hover:scale-102 hover:shadow-md
                        {{ $selectedUser?->id === $user['id'] ? 'bg-gradient-to-r from-ungumain/10 to-purple-500/10 shadow-md' : 'hover:bg-gray-100' }}">
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-ungumain to-purple-600 text-white flex items-center justify-center font-medium shadow-md">
                                {{ $user['initials'] }}
                            </div>
                            @if($user['unread_count'] > 0)
                                <div class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center animate-pulse shadow-lg">
                                    {{ $user['unread_count'] }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 overflow-hidden">
                            <h3 class="font-medium text-gray-800">{{ $user['name'] }}</h3>
                            @if($user['last_message'])
                                <p class="text-sm text-gray-600 truncate">{{ $user['last_message'] }}</p>
                                <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $user['last_message_time'] ? \Carbon\Carbon::parse($user['last_message_time'])->diffForHumans() : '' }}
                                </p>
                            @endif
                        </div>
                    </div>
                </button>
            @endforeach
        </div>
    </div>

    <!-- Chat Area -->
    <div  class="flex-1 flex flex-col max-h-[70vh]">
        @if($selectedUser)
            <div class="p-4 border-b bg-gradient-to-r from-ungumain to-purple-600 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-white/20 text-white flex items-center justify-center font-medium backdrop-blur-sm">
                    {{ strtoupper(substr($selectedUser->name, 0, 2)) }}
                </div>
                <h3 class="font-medium text-white">{{ $selectedUser->name }}</h3>
            </div>

            <div id="messages-container" class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50">
                @foreach($messages as $message)
                    <div class="message {{ $message['is_mine'] ? 'ml-auto' : 'mr-auto' }} max-w-[70%]">
                        <div class="flex {{ $message['is_mine'] ? 'justify-end' : 'justify-start' }}">
                            <div class="rounded-lg p-3 shadow-md {{ $message['is_mine'] ? 'bg-gradient-to-r from-ungumain to-purple-600 text-white' : 'bg-white' }}">
                                <p>{{ $message['message'] }}</p>
                                <div class="text-xs {{ $message['is_mine'] ? 'text-gray-200' : 'text-gray-500' }} mt-2 flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ \Carbon\Carbon::parse($message['created_at'])->format('g:i A') }}
                                    @if($message['is_mine'])
                                        · 
                                        @if($message['read_at'])
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="p-4 border-t bg-white">
                <form wire:submit.prevent="sendMessage" class="flex gap-2">
                    <input type="text" 
                           wire:model.defer="message" 
                           wire:keydown.enter="sendMessage"
                           class="flex-1 rounded-lg border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-ungumain transition-all"
                           placeholder="Type a message...">
                    <button type="submit"
                        class="bg-gradient-to-r from-ungumain to-purple-600 text-white px-6 py-3 rounded-lg hover:shadow-lg transition duration-300 transform hover:scale-105 flex items-center gap-2">
                        <span>Send</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </button>
                </form>
            </div>
        @else
            <div class="flex-1 flex flex-col items-center justify-center text-gray-500 space-y-4">
                <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
                <p class="text-lg">Select a conversation to start chatting</p>
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    let messagesContainer = document.getElementById('messages-container');
    let observer = null;

    function scrollToBottom() {
        if (messagesContainer) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    }

    function initializeObserver() {
        if (observer) {
            observer.disconnect();
        }

        messagesContainer = document.getElementById('messages-container');

        if (messagesContainer) {
            observer = new MutationObserver(() => {
                scrollToBottom();
            });

            observer.observe(messagesContainer, {
                childList: true,
                subtree: true,
            });

            scrollToBottom();
        }
    }


    Livewire.hook('message.processed', (message, component) => {
        if (component.fingerprint.name === "App\\Livewire\\ChatWithUser") { 
                initializeObserver();
        }
    });

    Livewire.on('userSelected', () => {
        initializeObserver();
    });

    @if($selectedUser)
        initializeObserver();
    @endif
});
</script>