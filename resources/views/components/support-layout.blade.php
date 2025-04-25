<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>Support Staff Dashboard</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">
<div class="min-h-screen">
    <header class="bg-blue-700 text-white p-4 mb-6">
        <h1 class="text-lg font-bold">Support Staff Dashboard</h1>
    </header>
    <main class="px-6">
        {{ $slot }}
    </main>
</div>
</body>
</html>
