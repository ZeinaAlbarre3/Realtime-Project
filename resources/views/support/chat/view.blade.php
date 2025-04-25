<x-support-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Chat with customer</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            <div class="space-y-4 mb-6">
                @foreach($messages as $message)
                    <div class="flex {{ $message->sender_type === \App\Models\SupportStaff::class ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-xs p-3 rounded-lg {{ $message->sender_type === \App\Models\SupportStaff::class ? 'bg-blue-100 text-blue-800' : 'bg-gray-200 text-gray-800' }}">
                            <p class="text-sm">{{ $message->text }}</p>
                            <p class="text-xs text-gray-500 mt-1 text-right">{{ $message->created_at->format('H:i') }}</p>
                        </div>
                    </div>
                @endforeach

            </div>

            <form method="POST" action="#">
                @csrf
                <div class="flex">
                    <input type="text" name="message" class="flex-1 border p-2 rounded-l" placeholder="write a message...">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-r">send</button>
                </div>
            </form>
        </div>
    </div>
</x-support-layout>
