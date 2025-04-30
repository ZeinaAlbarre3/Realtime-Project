<!-- resources/views/support/dashboard.blade.php -->
<x-support-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Welcome, {{ auth('support')->user()->name }}</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            <p>Welcome to the Support Dashboard.</p>

            <form action="{{ route('support.logout') }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md">
                    Logout
                </button>
            </form>

            <div class="mt-4">
                <a href="{{ route('support.chat.requests') }}" class="text-blue-600 hover:text-blue-800">
                    View Chat Requests
                </a>
            </div>
        </div>
    </div>
</x-support-layout>
