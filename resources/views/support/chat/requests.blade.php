<x-support-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Chat Requests</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto space-y-10">

        <div>
            <h3 class="text-lg font-bold mb-4">New Chat Requests</h3>
            @forelse($unassigned as $conv)
                <div class="mb-2">
                    <a href="{{ route('support.chat.view', $conv->id) }}" class="text-blue-600 underline">
                        Conversation with {{ $conv->users->first()->name ?? 'Unknown User' }}
                    </a>
                </div>
            @empty
                <p class="text-gray-500">No new chat requests.</p>
            @endforelse
        </div>

        <div>
            <h3 class="text-lg font-bold mb-4">My Conversations</h3>
            @forelse($mine as $conv)
                <div class="mb-2">
                    <a href="{{ route('support.chat.view', $conv->id) }}" class="text-green-600 underline">
                        Conversation with {{ $conv->users->first()->name ?? 'Unknown User' }}
                    </a>
                </div>
            @empty
                <p class="text-gray-500">You have no assigned conversations.</p>
            @endforelse
        </div>

    </div>
</x-support-layout>
