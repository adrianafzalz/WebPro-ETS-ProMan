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
    <link rel="stylesheet" href="/CSS/reseter.css">
    <link rel="stylesheet" href="/CSS/ListPage.css">
</head>

<body>
    <header>
        <div class="top-bar">
            <div class="profile-icon">
            <a href="{{ route('user.me') }}">
                <img src="/images/Profile Buttons.svg" alt="Profile Icon">
            </a>
            </div>

            <div class="search-bar">
                <input type="text" placeholder="Search user">
                <button id="searchBtn" type="button" class="btn-primary" style="cursor: pointer"><img src="/images/Oval.png" alt="Search Icon" class="search-icon">
                </button>
            </div>


            <script>
                $(function() {
                    $('#searchBtn').on('click', function() {
                        const q = $('.search-bar input[type="text"]').val().trim();
                        console.log(q);
                        if (!q) {
                            $('.search-bar input[type="text"]').focus();
                            return;
                        }

                        window.location.href = '{{ url("/user/find") }}' + "/" + encodeURIComponent(q);
                    });
                });
            </script>

            <div class="auth-icon" style="margin-left:1rem;">
                @auth
                <form action="{{ route('project.create.page') }}" method="GET" style="display:inline;">
                    <button type="submit" class="sign-in">
                        Add Project
                        <img src="/images/plus.svg" alt="Create Project Icon">
                    </button>
                </form>
                @endauth
            </div>

            <div class="auth-buttons" style="margin-left: 10px;">
                @auth
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="register">Logout</button>
                </form>
                @else
                <a href="{{ route('login') }}"><button class="sign-in">Sign in<img src="/images/Vector Line.svg"></button></a>
                <a href="{{ route('regis') }}"><button class="register">Register</button></a>
                @endauth
            </div>
        </div>

        <div class="header-content">
            <h1><span>{{ Auth::user()->user_name ?? 'Guest' }}’s</span> Projects</h1>
            <p>
                Welcome to your project dashboard. Here you can see all your active, planned, and completed projects. <br> <br>
                {{ Auth::user()->user_desc}} 
            </p>
        </div>
    </header>

    <main>
        <section class="projects">
            {{-- Loop project list --}}
            @forelse($projects as $project)
            @php
            $id = data_get($project, 'ID');
            $name = data_get($project, 'project_name');
            $desc = data_get($project, 'project_desc');
            $status = data_get($project, 'project_status.status_name') ?? data_get($project, 'project_status.status_name', '');
            $techs = data_get($project, 'project_tech_stacks', []);
            $collabs = data_get($project, 'collaborators', []);
            @endphp
            <div class="card {{ strtolower($project->status_color ?? 'green') }}">
                <div class="card-content">
                    <h3>{{ $name }}</h3>
                    <p>{{ Str::limit($desc, 100) }}</p>

                    <div class="tags">
                        @foreach($techs ?? ['Laravel', 'PHP'] as $tech)
                        @php
                        $techName = data_get($tech, 'tech_name');
                        $techColor = data_get($tech, 'tech_color') ?: '#d1d5db';
                        @endphp
                        <span>{{ $techName }}</span>
                        @endforeach
                    </div>

                    <div class="card-actions">
                        <div class="icons">
                            <span>
                                <img src="/images/Vector Bookmark.svg" alt="Bookmark">
                            </span>
                            @if(!empty($project->link))
                            <a href="{{ $project->link }}" target="_blank">
                                <img src="/images/Vector link copy for list.svg" alt="Link">
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