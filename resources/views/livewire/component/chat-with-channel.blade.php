<div x-data="{ 
    isChatboxOpen: false,
    initializeChat() {
        this.$nextTick(() => {
            this.scrollToBottom();
        });
    },
    scrollToBottom() {
        const container = document.getElementById('messages-container');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    }
}" 
@chatbox-opened="initializeChat">
    <!-- Enhanced Chat Toggle Button -->
    <div class="fixed bottom-0 right-0 mb-4 mr-4">
        <button @click="isChatboxOpen = !isChatboxOpen; $dispatch('chatbox-opened')"
            class="group bg-gradient-to-r from-ungumain to-purple-600 text-white py-3 px-6 flex items-center gap-3 rounded-full hover:shadow-lg transform hover:scale-105 transition-all duration-300">
            <div :class="{'rotate-180': isChatboxOpen, 'rotate-0': !isChatboxOpen}"
                class="transform transition-transform duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
            </div>
            <span x-show="!isChatboxOpen" 
                  class="font-semibold group-hover:tracking-wider transition-all duration-300 flex items-center gap-2">
                Chat with Channel
            </span>
        </button>
    </div>

    <div x-show="isChatboxOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-90"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-90"
         class="fixed bottom-16 right-4 w-96">
        <div class="bg-white shadow-xl rounded-lg max-w-lg w-full overflow-hidden">
            <div class="p-4 border-b bg-gradient-to-r from-ungumain to-purple-600 text-white rounded-t-lg flex justify-between items-center">
                <p class="text-lg font-semibold">{{ $channel->channel_name }}</p>
                <button @click="isChatboxOpen = false"
                    class="text-gray-300 hover:text-white focus:outline-none transform hover:rotate-90 transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div wire:poll.5s="loadMessages" id="messages-container" class="p-4 h-80 overflow-y-auto space-y-3 bg-gray-50">
                @foreach($messages as $msg)
                    <div class="message {{ $msg['sender_id'] === Auth::id() ? 'sent' : 'received' }}"
                         x-data="{ show: false }"
                         x-init="show = true; $nextTick(() => $parent.scrollToBottom())"
                         x-show="show"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform -translate-y-4"
                         x-transition:enter-end="opacity-100 transform translate-y-0">
                        <div class="flex {{ $msg['sender_id'] === Auth::id() ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[80%] p-3 rounded-lg shadow-md 
                                {{ $msg['sender_id'] === Auth::id() ? 'bg-gradient-to-r from-ungumain to-purple-600 text-white' : 'bg-white text-gray-700' }}">
                                <div class="font-semibold">{{ $msg['sender_name'] }}:</div>
                                <p>{{ $msg['message'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Enhanced Input Area -->
            <div class="p-4 border-t bg-gray-50 flex items-center space-x-2">
                <input type="text" 
                    wire:model="message" 
                    wire:keydown.enter="sendMessage"
                    class="w-full px-4 py-3 border rounded-l-md focus:outline-none focus:ring-2 focus:ring-ungumain transition-all"
                    placeholder="Type a message...">
                <button wire:click="sendMessage"
                    class="bg-gradient-to-r from-ungumain to-purple-600 text-white px-6 py-3 rounded-r-md hover:shadow-lg transition duration-300 transform hover:scale-105 flex items-center gap-2">
                    <span>Send</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        const messagesContainer = document.getElementById('messages-container');

        const scrollToBottom = () => {
            if (messagesContainer) {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
        };
        Livewire.on('messageSent', () => {
                setTimeout(scrollToBottom, 100);
            });
            Echo.private(`chat.${@entangle('channel.id')}`)
    .listen('.MessageSent', (e) => {
        Livewire.dispatch('newMessage', e);
    });

        Livewire.on('newMessage', () => {
            setTimeout(scrollToBottom, 100);
        });

        scrollToBottom();
    });
</script>