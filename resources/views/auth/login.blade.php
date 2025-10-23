<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

    <link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+Antique&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('CSS/reseter.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/login.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="bg-fullscreen">
        <form class="login-tab" method="POST" action="{{ route('login.attempt') }}" role="form" aria-labelledby="login-heading">
            @csrf

            <div class="login-row login-heading" id="login-heading">Login</div>

            {{-- Error messages --}}
            @if($errors->any())
                <div class="login-row" style="color:red; font-size:0.9em;">
                    <ul style="list-style:none; padding:0; margin:0;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="login-row login-email">
                <input id="user_name" name="user_name" type="text" placeholder="Username"
                       value="{{ old('user_name') }}" required />
            </div>

            <div class="login-row login-password">
                <input id="password" name="password" type="password" placeholder="Password" required />
                <button type="button" class="password-toggle" aria-label="Toggle password visibility" aria-pressed="false">
                    <img src="\images\eye.png" width="20" height="20" alt="show password" />
                </button>
            </div>

            <div class="login-row login-action">
                <button id="login-btn" type="submit"><span class="btn-text">Login</span></button>
            </div>

            <div class="login-row login-signup">
                 Don’t have an account? <a href="{{ route('regis') }}">Sign up here!</a>
            </div>
        </form>
    </div>

<script>
$(document).ready(function(){
    const $toggle = $('.password-toggle');
    const $pwd = $('#password');
    if(!$toggle.length || !$pwd.length) return;

    let visible = false;
    const strike = () => $('<div class="strike-line"></div>').css({
        position: 'absolute',
        top: '50%',
        left: '50%',
        width: '83%',
        height: '1.6px',
        background: '#8F9185',
        pointerEvents: 'none',
        transform: 'translate(-50%, -50%) rotate(-20deg)',
        borderRadius: '2px'
    });

    strike().appendTo($toggle);

    $toggle.on('click', function(){
        visible = !visible;
        $pwd.attr('type', visible ? 'text' : 'password');
        $(this).find('.strike-line').remove();
        if(!visible) strike().appendTo(this);
    });
});
</script>
</body>
</html>
