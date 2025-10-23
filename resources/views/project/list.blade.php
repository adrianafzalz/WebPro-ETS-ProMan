<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects List</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+Antique&display=swap" rel="stylesheet">

    {{-- Styles --}}
    <link rel="stylesheet" href="{{ asset('CSS/reseter.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/ListPage.css') }}">
</head>

<body>
    <header>
        <div class="top-bar">
            <div class="profile-icon">
                <img src="{{ asset('images\Profile Buttons.svg') }}" alt="Profile Icon">
            </div>

            <div class="search-bar">
                <input type="text" placeholder="Search user">
                <button id="searchBtn" type="button" class="btn-primary" style="cursor: pointer"><img src="\images\Oval.png" alt="Search Icon" class="search-icon">
                </button>
            </div>

            <div class="auth-buttons">
                @auth
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="sign-in">Logout<img src="{{ asset('images\logout.svg') }}"></button>
                </form>
                @else
                <a href="{{ route('login') }}"><button class="sign-in">Sign in<img src="{{ asset('images\Vector Line.svg') }}"></button></a>
                <a href="{{ route('register') }}"><button class="register">Register</button></a>
                @endauth
            </div>
        </div>

        <div class="header-content">
            <h1><span>{{ Auth::user()->name ?? 'Guest' }}’s</span> Projects</h1>
            <p>
                Welcome to your project dashboard. Here you can see all your active, planned, and completed projects.
            </p>
        </div>
    </header>

    <main>
        <section class="projects">
            {{-- Loop project list --}}
            @forelse($projects as $project)
            <div class="card {{ strtolower($project->status_color ?? 'green') }}">
                <div class="card-content">
                    <h3>{{ $project->name }}</h3>
                    <p>{{ Str::limit($project->description, 100) }}</p>

                    <div class="tags">
                        @foreach($project->technologies ?? ['Laravel', 'PHP'] as $tech)
                        <span>{{ $tech }}</span>
                        @endforeach
                    </div>

                    <div class="card-actions">
                        <div class="icons">
                            <span>
                                <img src="{{ asset('images\Vector Bookmark.svg') }}" alt="Bookmark">
                            </span>
                            @if(!empty($project->link))
                            <a href="{{ $project->link }}" target="_blank">
                                <img src="{{ asset('images\Vector link copy for list.svg') }}" alt="Link">
                            </a>
                            @endif
                        </div>
                        <a href="{{ route('project.detail', $id) }}">
                            <button class="details-btn">Details</button>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <p style="text-align:center; margin-top:2rem;">No projects found.</p>
            @endforelse
        </section>
    </main>
</body>

</html>