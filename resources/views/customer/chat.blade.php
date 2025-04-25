<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Support Chat</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            <div class="space-y-4 mb-6">
                @if($messages->isEmpty())
                    <p class="text-center text-gray-500">No messages yet. Start the conversation!</p>
                @else
                    @foreach($messages as $message)
                        <div class="flex {{ $message->sender_type === \App\Models\User::class ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-xs p-3 rounded-lg {{ $message->sender_type === \App\Models\User::class ? 'bg-blue-100 text-blue-800' : 'bg-gray-200 text-gray-800' }}">
                                <p class="text-sm">{{ $message->text }}</p>
                                <p class="text-xs text-gray-500 mt-1 text-right">{{ optional($message->created_at)->format('H:i') }}</p>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>

            <form method="POST" action="{{ route('customer.chat.view', $conversation->id) }}">
                @csrf
                <div class="flex">
                    <input type="text" name="message" class="flex-1 border p-2 rounded-l" placeholder="Write a message...">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-r">Send</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
