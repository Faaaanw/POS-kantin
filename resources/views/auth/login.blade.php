<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>

    @if ($errors->any())
        <div style="color:red;">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- Input email -->
    <input type="email" name="email" required>

    <!-- Input password -->
    <input type="password" name="password" required>

    <button type="submit">Login</button>
</form>

</body>
</html>
