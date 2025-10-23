<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>

    {{-- Fonts & CSS --}}
    <link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+Antique&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/CSS/reseter.css') }}">
    <link rel="stylesheet" href="/CSS/register.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="bg-fullscreen">
        <form class="register-tab" method="POST" action="/auth/register">
            @csrf

            <div class="reg-heading">Create New Account</div>
            <div class="reg-subtext">Already have account? 
                <a href="{{ route('login') }}" class="reg-login-link">Login here!</a>
            </div>

            {{-- Error Display --}}
            @if($errors->any())
                <div style="color:red; font-size:0.9em;">
                    <ul style="list-style:none; padding:0;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Name --}}
            <div class="name-row">
                <div class="name-field first-name">
                    <input type="text" name="first_name" placeholder="First name" value="{{ old('first_name') }}" required />
                </div>
                <div class="name-field last-name">
                    <input type="text" name="last_name" placeholder="Last name" value="{{ old('last_name') }}" required />
                </div>
            </div>

            {{-- Username / Email --}}
            <div class="user-name-row">
                <input type="text" name="user_name" placeholder="Username" value="{{ old('email') }}" required />
            </div>

            {{-- Password --}}
            <div class="password-row">
                <input id="password" name="password" type="password" placeholder="Password" required />
                <button type="button" class="password-toggle" aria-label="Toggle password visibility" aria-pressed="false">
                    <img src="\images\eye.png" width="20" height="20" alt="show password" />
                </button>
            </div>

            {{-- Terms --}}
            <div class="terms-row">
                <input type="checkbox" id="agree-terms" name="terms" required />
                <label for="agree-terms" class="terms-text">
                    I agree <a href="https://lipsum.com/feed/html" class="terms-text-link">Terms & Conditions</a>
                </label>
            </div>

            {{-- Submit --}}
            <div class="register-action">
                <button type="submit" class="register-btn">Create Account</button>
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