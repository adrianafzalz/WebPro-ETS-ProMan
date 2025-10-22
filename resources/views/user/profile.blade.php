{{-- resources/views/user/profile.blade.php --}}
{{-- Blade view: Projects list UI
    Expects $projects (array/collection). Uses data_get() so it works with arrays or objects. --}}

<div class="profile-projects-container" style="font-family:system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; padding:20px; max-width:1100px; margin:0 auto;">
    <header style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px;">
       <div>
          <h1 style="margin:0; font-size:1.5rem;">Projects</h1>
          <p style="margin:4px 0 0; color:#6b7280;">Showing {{ count($projects ?? []) }} project{{ count($projects ?? []) !== 1 ? 's' : '' }}</p>
       </div>
    </header>

    @if(empty($projects) || count($projects) === 0)
       <div style="padding:28px; border:1px dashed #e5e7eb; border-radius:8px; text-align:center; color:#6b7280;">
          No projects to display.
       </div>
    @else
       <div class="grid" style="display:grid; grid-template-columns:repeat(auto-fill,minmax(300px,1fr)); gap:16px;">
          @foreach($projects as $project)
             @php
                $id = data_get($project, 'ID');
                $name = data_get($project, 'project_name');
                $desc = data_get($project, 'project_desc');
                $status = data_get($project, 'project_status.status_name') ?? data_get($project, 'project_status.status_name', '');
                $techs = data_get($project, 'project_tech_stacks', []);
                $collabs = data_get($project, 'collaborators', []);
             @endphp

             <article style="background:#fff; border:1px solid #e6e9ee; border-radius:10px; padding:16px; box-shadow:0 1px 2px rgba(16,24,40,0.02);">
                <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:12px;">
                    <div style="flex:1;">
                       <h2 style="margin:0 0 6px; font-size:1.05rem; color:#111827;">{{ $name }}</h2>
                       <p style="margin:0; color:#4b5563; font-size:0.94rem;">{{ $desc }}</p>
                    </div>

                    <div style="margin-left:12px; text-align:right;">
                       <span style="display:inline-block; padding:6px 10px; font-size:0.78rem; border-radius:999px; background:#f3f4f6; color:#374151;">
                          {{ $status }}
                       </span>
                    </div>
                </div>

                <div style="margin-top:12px; display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;">
                    <div class="techs" style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                       @if(!empty($techs) && count($techs) > 0)
                          @foreach($techs as $tech)
                             @php
                                $techName = data_get($tech, 'tech_name');
                                $techColor = data_get($tech, 'tech_color') ?: '#d1d5db';
                             @endphp
                             <span style="display:inline-flex; align-items:center; gap:8px; padding:6px 8px; border-radius:999px; background:#f8fafc; font-size:0.80rem; color:#111827;">
                                <span style="width:12px; height:12px; border-radius:50%; display:inline-block; background:{{ $techColor }}; box-shadow:inset 0 0 0 1px rgba(0,0,0,0.06);"></span>
                                <span>{{ $techName }}</span>
                             </span>
                          @endforeach
                       @else
                          <span style="font-size:0.85rem; color:#9ca3af;">No tech stacks</span>
                       @endif
                    </div>

                    <div class="collabs" style="display:flex; gap:8px; align-items:center;">
                       @if(!empty($collabs) && count($collabs) > 0)
                          @foreach($collabs as $c)
                             @php
                                $uname = data_get($c, 'user_name') ?? 'User';
                                $role = data_get($c, 'pivot.role') ?? data_get($c, 'pivot')['role'] ?? '';
                                // initial fallback
                                $initials = collect(explode(' ', $uname))->filter()->map(fn($p)=> strtoupper(substr($p,0,1)))->slice(0,2)->join('');
                                $bg = data_get($c, 'user_bg_color') ?: '#94a3b8';
                                $fg = data_get($c, 'user_fg_color') ?: '#ffffff';
                             @endphp

                             <div title="{{ $uname }}{{ $role ? ' — '.$role : '' }}" style="display:inline-flex; flex-direction:column; align-items:center; gap:4px;">
                                <div style="width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; background:{{ $bg }}; color:{{ $fg }}; font-weight:600; font-size:0.85rem; box-shadow:0 1px 0 rgba(0,0,0,0.04);">
                                    {{ $initials }}
                                </div>
                                @if($role)
                                    <small style="font-size:0.65rem; color:#6b7280;">{{ $role }}</small>
                                @endif
                             </div>
                          @endforeach
                       @else
                          <small style="color:#9ca3af;">No collaborators</small>
                       @endif
                    </div>
                </div>

                <div style="margin-top:12px; display:flex; justify-content:flex-end;">
                    <a href="{{ url('/project/detail/'.$id) }}" style="text-decoration:none; padding:8px 12px; font-size:0.88rem; border-radius:8px; background:#0ea5a9; color:white;">View</a>
                </div>
             </article>
          @endforeach
       </div>
    @endif
</div>