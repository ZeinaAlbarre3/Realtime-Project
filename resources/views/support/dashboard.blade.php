<!DOCTYPE html>
<html>
<head>
    <title>Support Dashboard</title>
</head>
<body>
<h2>Welcome, {{ auth('support')->user()->name }}</h2>

<form action="{{ route('support.logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>

<a href="{{ route('support.chat.requests') }}">View Chat Requests</a>

</body>
</html>
