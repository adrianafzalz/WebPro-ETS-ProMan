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

        <div>
            <label for="desc">Description</label>
            <input id="desc" name="desc" type="textarea" />
        </div>
        
        <div>
            <label for="fgcolor">Foreground Color</label>
            <input id="fgcolor-input" name="fgcolor" type="color" />
        </div>
        <div>
            <label for="bgcolor">Foreground Color</label>
            <input id="bgcolor-input" name="bgcolor" type="color" />
        </div>
        <div>
            <label for="accentcolor">Foreground Color</label>
            <input id="accentcolor-input" name="accentcolor" type="color" />
        </div>

        <button type="submit">Login</button>
    </form>
</body>
</html>