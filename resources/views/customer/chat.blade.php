<x-app-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-slot name="header">
        <h2 class="text-xl font-semibold">Customer Chat</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white p-6 rounded shadow">

            <div id="chat-box" data-conversation="{{ $conversation->id }}" data-user-id="{{ auth('web')->id() }}">

                @foreach($messages as $message)
                    <div class="flex {{ $message->sender_type === \App\Models\User::class ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-xs p-3 rounded-lg {{ $message->sender_type === \App\Models\User::class ? 'bg-blue-100 text-blue-800' : 'bg-gray-200 text-gray-800' }}">
                            <p class="text-sm">{{ $message->text }}</p>
                            <p class="text-xs text-gray-500 mt-1 text-right">{{ $message->created_at->format('H:i') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <form id="send-message-form"
                  x-data="{ text: '' }"
                  @submit.prevent="
                    fetch('{{ route('customer.chat.send', $conversation->id) }}', {
                        method: 'POST',
                         headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                                'X-Active-Conversation': '{{ $conversation->id }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                        body: JSON.stringify({ text: text })
                    })
                  .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw new Error(data.message || 'Error');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Message sent successfully', data);
                    text = '';
                    const userType = document.body.dataset.userType;
                })
                .catch(error => {
                    console.error('Error sending message', error.message);
                    window.dispatchEvent(new CustomEvent('chat-notify', {
                        detail: { message: error.message }
                    }));
                });

                "
                  class="flex mt-4"
            >
                <input type="text" id="message-input" x-model="text" class="flex-1 border p-2 rounded-l" placeholder="Write a message..." autocomplete="off">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-r">Send</button>
            </form>

        </div>
    </div>


    @vite(['resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>


</x-app-layout>
