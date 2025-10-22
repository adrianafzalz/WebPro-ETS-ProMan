{{-- resources/views/project-details.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Details</title>
    
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+Antique&display=swap" rel="stylesheet">
    
    {{-- Styles --}}
    <link rel="stylesheet" href="{{ asset('CSS/reseter.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/ProjectDetails.css') }}">
</head>
<body>
    <header>  
        <img class="logo" src="{{ asset('https://pouch.jumpshare.com/preview/fPpqkXM7WzFcPHmhbPKkXwR938JiGQVUgdji8sTP8pJcBiQXHOaci62OEK3H1LvMVZXbsatgj5ITUWQpsWReOzWFPH5p5hwX-AwRCVBCDy4') }}" alt="Logo">
        <img src="{{ asset('https://pouch.jumpshare.com/preview/fAURzBTkLDx5uCgCv9Lini69NkOFgn5ytf7tHa4eQ8HldgmBJFa29TK1QQZ58Jm6FBnGYulZ7fgJXStAkNVXPcaMzrhidpaSwdq4YEEGDKQ') }}" alt="Status Icon" class="status">
    </header>

    <main>
        <div class="project-tab">
            <div class="project-header">
                <div class="project-name-time">
                    <h1>{{ $project->project_name ?? 'Project Title' }}</h1>
                    <div class="project-times-details">
                        <img src="{{ asset('https://pouch.jumpshare.com/preview/k9LEvQ8obRTci8CtBqEvb31VZu0Wi0XVwuNBD32SCqYwlRAMaGjDrdaAm64_EbVfFBnGYulZ7fgJXStAkNVXPczbZtu5uEJQbdXw7qoGlww') }}" alt="Calendar Icon" class="calendar-icon">
                        <p class="dates">{{ $project->project_start ?? 'DD/MM/YYYY' }} -</p>
                        <img src="{{ asset('https://pouch.jumpshare.com/preview/cF74zRhRaNpj7QnBk8bBjO9tzE2Iu6oTSYbfdVmo3kfMaEFyCJQe5JynFFn0S7PrFBnGYulZ7fgJXStAkNVXPYlNZFVuHI9htH9JJ8xAjK8') }}" alt="Time Icon" class="time-icon">
                        <p class="week-text">{{ $project->project_end ?? 'has not ended' }}</p>
                    </div>
                </div>
                <div class="project-tab-buttons">
                    <button class="edit-btn">
                        <img src="{{ asset('https://pouch.jumpshare.com/preview/Y385137rEY02Ji2rC-RT72hwV117mfb2bClqHujcYmGuIZP3-o1Vx010ypCKL4EqFBnGYulZ7fgJXStAkNVXPRkqW1SYpqoTn9Oftyb8Emk') }}" alt="Edit">
                    </button>
                    <button class="delete-btn">
                        <img src="{{ asset('https://pouch.jumpshare.com/preview/m8HJ0pygE57P5bX6MLqjYI5i8ThwLRQTYiJnpuA8Fz_BvSEmIEqirsCbF-QXWU6XFBnGYulZ7fgJXStAkNVXPRNX3cxg5jQ6q3xzu5dWWHI') }}" alt="Delete">
                    </button>
                </div>
            </div>

            <p class="project-description">
                {{ $project->project_desc ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...' }}
            </p>

            <div class="info-section">
                <div class="technologies">
                    <h4>Technologies</h4>
                    <div class="tags">
                        @forelse ($project->project_tech_stacks ?? [] as $tech)
                            <span>{{ $tech->tech_name }}</span>
                        @empty
                            <span>No tech listed</span>
                        @endforelse
                    </div>
                </div>
                <div class="collaborator">
                    <span>
                        <img src="{{ asset('https://pouch.jumpshare.com/preview/VuP1qx4NVVHCRDq2jLgKHU_8bnaIQfNdHYtv_TeLtSNM8hoq7v-HKtv72mxLtS67FBnGYulZ7fgJXStAkNVXPZngA-Rp0b1yZCRFgzFlmM0') }}" alt="Collaborator Icon">
                        <h4>Collaborator</h4>
                    </span>
                    <div class="tags">
                        @forelse ($project->collaborators ?? [] as $col)
                            <span>{{ $col->user_name }}</span>
                        @empty
                            <span>None</span>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="link-section">
                @if(!empty($project->project_links))
                    <a href="{{ $project->link }}" target="_blank" class="link-btn">
                        <img src="{{ asset('https://pouch.jumpshare.com/preview/_oNocaCluao8XEZ-j9D6vSb9VgIoymQUldn-MFkEiuJhgqIRtbvCe8WexwoFJotmFBnGYulZ7fgJXStAkNVXPQjhN2Y31521YAy_VcoR_r4 ') }}" alt="Link">Link
                    </a>
                @else
                    <button class="link-btn" disabled>
                        <img src="{{ asset('https://pouch.jumpshare.com/preview/_oNocaCluao8XEZ-j9D6vSb9VgIoymQUldn-MFkEiuJhgqIRtbvCe8WexwoFJotmFBnGYulZ7fgJXStAkNVXPQjhN2Y31521YAy_VcoR_r4') }}" alt="Link">No Link
                    </button>
                @endif
            </div>

            <hr>

            <div class="add-comment-section">
                <h4>Add Comment</h4>
                <form method="POST" action="">
                    @csrf
                    <textarea class="comment-input" name="comment" placeholder="Write your comment here..."></textarea>
                    <button type="submit" class="post-comment-btn">Post Comment</button>
                </form>
            </div>

            <div class="comments-section">
                <h4>Comments</h4>
                @forelse ($project->comments ?? [] as $comment)
                    <div class="comment">{{ $comment->text }}</div>
                @empty
                    <div class="comment">No comments yet</div>
                @endforelse
            </div>
        </div>
    </main>
</body>
</html>
