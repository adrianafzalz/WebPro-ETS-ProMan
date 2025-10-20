<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>

    @if($errors->any())
        <div style="color:red">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login.attempt') }}">
        @csrf
        <div>
            <label for="user_name">Username</label>
            <input id="user_name" name="user_name" value="{{ old('user_name') }}" />
        </div>
        <div>
            <label for="password">Password</label>
            <input id="password" name="password" type="password" />
        </div>
        <button type="submit">Login</button>
    </form>
</body>
</html>