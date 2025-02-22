<div class="bg-white shadow-lg mx-4 my-8 rounded-lg flex flex-row min-h-[70vh]">
    <!-- LIST USER CHAT -->
    <div class="w-1/4 border-r border-gray-300 overflow-y-auto">
        <div class="p-4 font-bold text-xl">Chats</div>
        @foreach($users as $chatUser)
            @if ($chatUser['id'] != Auth::id())
                <div wire:poll.2s="refreshLastMessage" wire:click="selectUser({{ $chatUser['id'] }})"
                    class="flex px-4 py-2 border-b cursor-pointer hover:bg-gray-100 
                                                                {{ isset($selectedUser) && $selectedUser->id === $chatUser['id'] ? 'bg-gray-100' : '' }}">
                    <div class="w-12 h-12 aspect-square bg-gray-300 rounded-full flex items-center justify-center">
                        <span class="text-lg font-semibold text-gray-600">{{ $chatUser['initials'] }}</span>
                        @if($chatUser['unread_count'] > 0)
                            <div class="absolute top-0 right-0 h-3 w-3 bg-red-500 rounded-full"></div>
                        @endif
                    </div>
                    <div class="flex flex-col ml-4">
                        <span class="font-bold line-clamp-1">{{ $chatUser['name'] }}</span>
                        <span class="text-sm text-gray-500 line-clamp-1">{{ $chatUser['last_message'] }}</span>
                    </div>
                </div>
            @endif
        @endforeach

    </div>

    <!-- ISI CHAT -->
    <div class="w-3/4 flex flex-col max-h-[70vh] bg-gray-100">
        @if($selectedUser)
            <div class="p-4 bg-ungumain text-white flex justify-between items-center">
                <h3 class="text-lg font-semibold">{{ $selectedUser->name }}</h3>
            </div>
            <div wire:poll.2s="refreshMessages" class="flex-1 p-4 space-y-4 max-h-[400px] overflow-y-auto"
                id="messageContainer">
                @foreach($messages as $msg)
                    <div class="mb-2 {{ $msg['is_mine'] ? 'text-right' : 'text-left' }}">
                        <p class="{{ $msg['is_mine'] ? 'bg-ungumain text-white' : 'bg-gray-200 text-gray-700' }} 
                                                                            rounded-lg py-2 px-4 inline-block">
                            {{ $msg['message'] }}
                        </p>
                    </div>
                @endforeach
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const messagesContainer = document.getElementById('messageContainer');

                    const scrollToBottom = () => {
                        if (messagesContainer) {
                            messagesContainer.scrollTop = messagesContainer.scrollHeight;
                        }
                    };
                    scrollToBottom();
                    Livewire.hook('message.processed', (message, component) => {
                        scrollToBottom();
                    });
                    Livewire.on('messageSent', () => {
                        setTimeout(() => {
                            scrollToBottom();
                        }, 100);
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

            <div class="flex-1 flex items-center justify-center text-gray-500">
                Select a user to start chatting
            </div>
        @endif
    </div>
</div>