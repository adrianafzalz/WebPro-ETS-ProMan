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
                <img src="{{ asset('https://pouch.jumpshare.com/preview/41stSxT1ssKNQ5z9mOBSrRQPko69FBUgSjlWhI711LzBRrmKMQQ5GaDYQSrQMHmFMnteyYIv80t-8hy424wsU8ol9YN6Qk-JQVRM9bOJ390') }}" alt="Profile Icon">
            </div>

            <div class="search-bar">
                <button id="searchBtn" class="search-icon" style="cursor: pointer">Search</button>
                <input type="text" placeholder="Search" name="search" value="{{ request('search') }}">
                {{-- <img src="{{ asset('https://i.postimg.cc/zXBRCkZz/Oval.png') }}" alt="Search Icon" class="search-icon"> --}}
            </div>


            <script>
            $(function(){
                $('#searchBtn').on('click', function(){
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

            <div class="profile-icon" style="margin-left:1rem;">
                @auth
                    <a href="{{ route('project.create.page') }}" aria-label="Create Project" style="color: black">
                        <button class="create-btn" type="sign-in">+</button>
                    </a>
                @endauth
            </div>

            <div class="auth-buttons">
                @auth
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="sign-in">Logout<img src="{{ asset('https://pouch.jumpshare.com/preview/ATkIwzDBRJjWHfbndB4-fYccJJaUHCfwcvT2KD49FZuDN2THK6Yf9No3gab__IZlMnteyYIv80t-8hy424wsU8_gDQQkv4SCiEdB6akbGxs') }}"></button>
                    </form>
                @else
                    <a href="{{ route('login') }}"><button class="sign-in">Sign in<img src="{{ asset('https://pouch.jumpshare.com/preview/ATkIwzDBRJjWHfbndB4-fYccJJaUHCfwcvT2KD49FZuDN2THK6Yf9No3gab__IZlMnteyYIv80t-8hy424wsU8_gDQQkv4SCiEdB6akbGxs') }}"></button></a>
                    <a href="{{ route('regis') }}"><button class="register">Register</button></a>
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
                                    <img src="{{ asset('https://pouch.jumpshare.com/preview/PJTfkhun7sWPIqGk5oJhxf4aCUIQqyb-E2PgsoCMcH1xxWi5csyEf59MwT59XUkZMnteyYIv80t-8hy424wsU5qEwZ_cqohBEnraREZs0ew ') }}" alt="Bookmark">
                                </span>
                                @if(!empty($project->link))
                                    <a href="{{ $project->link }}" target="_blank">
                                        <img src="{{ asset('https://pouch.jumpshare.com/preview/1SXj-_olLpYohcsCxGQFZA71qRVIO0Sst8epL7yXwt39AM_mgBnMh8MNCFQCByuKMnteyYIv80t-8hy424wsU5qEwZ_cqohBEnraREZs0ew') }}" alt="Link">
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
