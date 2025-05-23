<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body
    data-user-id="{{ auth('support')->check() ? auth('support')->id() : auth('web')->id() }}"
    data-user-type="{{ auth('support')->check() ? 'support' : 'user' }}"
    data-active-conversation="{{ request()->route('conversation')?->id }}"
>
<div class="min-h-screen bg-gray-100">
    @include('layouts.navigation')

    <!-- Page Heading -->
    @isset($header)
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>
</div>

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
