<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
    <a href="{{ route('customer.chat.view') }}">Send message to support staff</a>
    <div
        x-data="{ show: false, message: '' }"
        x-show="show"
        x-transition
        x-init="
            window.addEventListener('chat-notify', e => {
                message = e.detail.message;
                show = true;
                setTimeout(() => show = false, 5000);
            });
        "
        class="fixed bottom-4 right-4 bg-blue-600 text-white px-4 py-2 rounded shadow-lg text-sm z-50"
        style="display: none;"
    >
        <span x-text="message"></span>
    </div>

    @vite(['resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
</x-app-layout>
