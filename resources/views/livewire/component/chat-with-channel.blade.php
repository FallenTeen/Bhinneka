<div x-data="{ isChatboxOpen: false }" class="fixed bottom-0 right-0">
    <!-- Chat Toggle Button -->
    <button @click="isChatboxOpen = !isChatboxOpen"
        class="bg-ungumain text-white px-4 py-2 rounded-t-lg flex items-center space-x-2 mb-4 mr-4">
        <div :class="{'rotate-45': isChatboxOpen, 'rotate-0': !isChatboxOpen}"
            class="transform transition-transform duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
        </div>
        <span x-show="!isChatboxOpen">Chat with Channel</span>
    </button>

    <!-- Chat Box -->
    <div x-show="isChatboxOpen" 
        class="w-96 h-[600px] bg-white shadow-lg rounded-t-lg flex flex-col mr-4">
        <!-- Header -->
        <div class="p-4 bg-ungumain text-white rounded-t-lg">
            <div class="flex justify-between items-center">
                <h3 class="font-semibold">{{ $channel->channel_name }}</h3>
                <button @click="isChatboxOpen = false" class="text-white hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <!-- Typing Indicator -->
            @if(count($typingUsers) > 0)
                <div class="text-sm mt-2 italic">
                    @foreach($typingUsers as $userId => $data)
                        <div>{{ $data['name'] }} is typing...</div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Messages -->
        <div class="flex-1 overflow-y-auto p-4 space-y-3" id="messages-container">
            @foreach($messages as $msg)
                <div class="message {{ $msg['sender_id'] === Auth::id() ? 'flex justify-end' : 'flex justify-start' }}"
                    wire:key="message-{{ $msg['id'] }}">
                    <div class="max-w-[80%] break-words">
                        <div class="text-sm text-gray-600 mb-1">{{ $msg['sender_name'] }}</div>
                        <div class="{{ $msg['sender_id'] === Auth::id() 
                            ? 'bg-ungumain text-white' 
                            : 'bg-gray-100' }} rounded-lg p-3 shadow-sm">
                            {{ $msg['message'] }}
                        </div>
                        <div class="text-xs text-gray-500 mt-1 flex items-center">
                            {{ $msg['created_at'] }}
                            @if($msg['sender_id'] === Auth::id())
                                <span class="ml-2">
                                    @if($msg['read_at'])
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    @endif
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Input -->
        <div class="p-4 border-t">
            <div class="flex space-x-2">
                <input 
                    type="text" 
                    wire:model.debounce.300ms="message"
                    wire:keydown.enter="sendMessage"
                    class="flex-1 border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-ungumain"
                    placeholder="Type a message...">
                <button 
                    wire:click="sendMessage"
                    class="bg-ungumain text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                    Send
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('livewire:initialized', () => {
    const container = document.getElementById('messages-container');
    
    const scrollToBottom = () => {
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    };

    scrollToBottom();
    Livewire.on('refreshMessages', () => {
        setTimeout(scrollToBottom, 100);
    });

    Livewire.on('messageSent', () => {
        setTimeout(scrollToBottom, 100);
    });
    const observer = new MutationObserver(scrollToBottom);
    observer.observe(container, { childList: true, subtree: true });
});
</script>