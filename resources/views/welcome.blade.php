<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+Antique&display=swap" rel="stylesheet">

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('CSS/reseter.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/LandingPage.css') }}">

    {{-- JS --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="bg-fullscreen">
        {{-- Top Section --}}
        <div class="top-half">
            <div class="hero-text">
                <h1>Track Projects, Milestones,<br>
                    <span class="line-two">and People All In One Place</span>
                </h1>
                <p>
                    Record project names, start/end dates, status, assignees, short & long descriptions, attachments
                    <br>and milestones, then export the whole thing to a clean static HTML report.
                </p>
            </div>
        </div>

        {{-- Bottom Section --}}
        <div class="bottom-half">
            <div class="search-section">
                <input type="text" placeholder="Search projects, tasks, or teams...">
                <button id="searchBtn" type="button" class="btn-primary" style="cursor: pointer"><img src="images\Oval.png" alt="Search Icon" class="search-icon">
                </button>
            </div>

            <script>
                $(function() {
                    $('#searchBtn').on('click', function() {
                        const q = $('.search-section input[type="text"]').val().trim();
                        console.log(q);
                        if (!q) {
                            $('.search-section input[type="text"]').focus();
                            return;
                        }
                        // Go to your search route with query param (adjust URL if needed)
                        window.location.href = '{{ url("/user/find") }}' + "/" + encodeURIComponent(q);
                    });

                    $('#clearBtn').on('click', function() {
                        $('.search-section input[type="text"]').val('').focus();
                    });
                });
            </script>
            <div class="promo-text-section">
                <p>
                    <span class="t1">Let’s</span>
                    <span class="t2">Join</span>
                    <span class="t3">Us</span>
                </p>
            </div>

            <div class="action-buttons">
                <div class="sign-in-button">
                    <a href="{{ route('login') }}">
                        <button type="button">Sign in</button>
                    </a>
                </div>
                <div class="register-button">
                    <a href="{{ route('regis') }}">
                        <button type="button">Register</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>