<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Customer Staff Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body
    data-user-id="{{ auth('support')->check() ? auth('support')->id() : auth('web')->id() }}"
    data-user-type="{{ auth('support')->check() ? 'support' : 'user' }}"
    data-active-conversation="{{ request()->route('conversation')?->id }}"
>
<div class="min-h-screen">
    <header class="bg-blue-700 text-white p-4 mb-6">
        <h1 class="text-lg font-bold">Customer Staff Dashboard</h1>
    </header>
    <main class="px-6">
        {{ $slot }}
    </main>
</div>
<!-- Toast Notification UI -->
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
</body>
</html>
