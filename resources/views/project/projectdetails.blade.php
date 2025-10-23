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
    <link rel="stylesheet" href="/CSS/reseter.css">
    <link rel="stylesheet" href="/CSS/ProjectDetails.css">
</head>
<body>
    <header>  
        <a href="javascript:history.back()">
            <img class="logo" src="/images/Group 32.svg" alt="Logo">
        </a> 
        <img src="/images\Status Done.svg" alt="Status Icon" class="status">
    </header>

    <main>
        <div class="project-tab">
            <div class="project-header">
                <div class="project-name-time">
                    <h1>{{ $project->project_name ?? 'Project Title' }}</h1>
                    <div class="project-times-details">
                        <img src="/images\Vector Calendar.svg" alt="Calendar Icon" class="calendar-icon">
                        <p class="dates">{{ $project->project_start ?? 'DD/MM/YYYY' }} -</p>
                        <img src="/images\Vector Time.svg" alt="Time Icon" class="time-icon">
                        <p class="week-text">{{ $project->project_end ?? 'has not ended' }}</p>
                    </div>
                </div>
                <div class="project-tab-buttons">
                    <button class="edit-btn">
                        <img src="/images\Vector edit.svg" alt="Edit">
                    </button>
                    <button class="delete-btn">
                        <img src="/images\Vector delete.svg" alt="Delete">
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
                        <img src="/images\Icon.svg" alt="Collaborator Icon">
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
                        <img src="/images\Vector Link copy.svg" alt="Link">Link
                    </a>
                @else
                    <button class="link-btn" disabled>
                        <img src="/images\Vector Link copy.svg" alt="Link">No Link
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
