<!DOCTYPE html>
<html>
<head>
    <title>Support Staff Login</title>
</head>
<body>
<h2>Support Staff Login</h2>

@if ($errors->any())
    <div>{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('support.login.submit') }}">
    @csrf
    <label>Email:</label><br>
    <input type="email" name="email"><br><br>

    <label>Password:</label><br>
    <input type="password" name="password"><br><br>

    <button type="submit">Login</button>
</form>
</body>
</html>
