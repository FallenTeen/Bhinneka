<div x-data="{ isChatboxOpen: false }">
    <!-- Chat Toggle Button -->
    <div class="fixed bottom-0 right-0 mb-4 mr-4">
        <button @click="isChatboxOpen = !isChatboxOpen"
            class="bg-ungumain justify-center text-white py-2 flex rounded-md hover:bg-purple-700 transition duration-300 px-4 items-center">
            <div :class="{'rotate-45': isChatboxOpen, 'rotate-0': !isChatboxOpen}"
                class="transform transition-transform duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
            </div>
            <span x-show="!isChatboxOpen" class="duration-300 transition-all ease-in-out">
                Chat with Channel
            </span>
        </button>
    </div>

    <!-- Chat Box -->
    <div x-data="{ isChatboxOpen: false }">
    <!-- Chat Toggle Button -->
    <div class="fixed bottom-0 right-0 mb-4 mr-4">
        <button @click="isChatboxOpen = !isChatboxOpen"
            class="bg-ungumain justify-center text-white py-2 flex rounded-md hover:bg-purple-700 transition duration-300 px-4 items-center">
            <div :class="{'rotate-45': isChatboxOpen, 'rotate-0': !isChatboxOpen}"
                class="transform transition-transform duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
            </div>
            <span x-show="!isChatboxOpen" class="duration-300 transition-all ease-in-out">
                Chat with Channel
            </span>
        </button>
    </div>

    <!-- Chat Box -->
    <div x-show="isChatboxOpen" class="fixed bottom-16 right-4 w-96">
        <div class="bg-white shadow-lg rounded-lg max-w-lg w-full overflow-hidden">
            <!-- Header Chat -->
            <div class="p-4 border-b bg-ungumain text-white rounded-t-lg flex justify-between items-center">
                <p class="text-lg font-semibold">{{ $channel->channel_name }}</p>
                <button @click="isChatboxOpen = false"
                    class="text-gray-300 hover:text-gray-400 focus:outline-none focus:text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Chat Messages -->
            <div wire:poll.2s="refreshMessages" id="messages-container" class="p-4 h-80 overflow-y-auto flex flex-col-reverse space-y-3">
                @foreach($messages as $msg)
                    <div class="message {{ $msg['sender_id'] === Auth::id() ? 'sent' : 'received' }}">
                        <div class="flex {{ $msg['sender_id'] === Auth::id() ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[80%] p-3 rounded-lg shadow-sm 
                                {{ $msg['sender_id'] === Auth::id() ? 'bg-ungumain text-white' : 'bg-gray-200 text-gray-700' }}">
                                <div class="font-semibold">{{ $msg['sender_name'] }}:</div>
                                <p>{{ $msg['message'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Input Area -->
            <div class="p-4 border-t flex items-center space-x-2">
                <input type="text" 
                    wire:model.defer="message" 
                    wire:keydown.enter="sendMessage"
                    class="w-full px-4 py-3 border rounded-l-md focus:outline-none focus:ring-2 focus:ring-ungumain transition-all"
                    placeholder="Type a message...">
                <button wire:click="sendMessage"
                    class="bg-ungumain text-white px-6 py-3 rounded-r-md hover:bg-purple-700 transition duration-300 transform hover:scale-105">
                    Send
                </button>
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        const messagesContainer = document.getElementById('messages-container');

        const scrollToBottom = () => {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
        @this.on('messageSent', () => {
            setTimeout(() => {
                scrollToBottom();
            }, 50);
        });
        scrollToBottom();
    });
</script>
</div>
