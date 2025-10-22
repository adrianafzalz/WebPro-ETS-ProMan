{{-- resources/views/project/create.blade.php --}}
<form method="POST" action="{{ route('project.create.attempt') }}" enctype="multipart/form-data" onsubmit="preparePayload()">
    @csrf

    <div>
        <label for="project_name">Project name</label>
        <input id="project_name" name="project_name" type="text" value="{{ old('project_name') }}" required>
    </div>

    <div>
        <label for="project_desc">Description</label>
        <textarea id="project_desc" name="project_desc" rows="6">{{ old('project_desc') }}</textarea>
    </div>

    <div>
        <label for="project_start">Start date</label>
        <input id="project_start" name="project_start" type="date" value="{{ old('project_start') }}">
    </div>

    <div>
        <label for="project_date">End date</label>
        <input id="project_date" name="project_date" type="date" value="{{ old('project_date') }}">
    </div>

    <div>
        <label for="PROJECT_STATUS_ID">Status</label>
        <select id="PROJECT_STATUS_ID" name="PROJECT_STATUS_ID">
            {{-- Replace these options with dynamic statuses from the backend when available --}}
            <option value="1" {{ old('PROJECT_STATUS_ID') == 1 ? 'selected' : '' }}>OnGoing</option>
            <option value="2" {{ old('PROJECT_STATUS_ID') == 2 ? 'selected' : '' }}>Completed</option>
            <option value="3" {{ old('PROJECT_STATUS_ID') == 3 ? 'selected' : '' }}>Planned</option>
        </select>
    </div>

    {{-- Links (object mapping e.g. { "a": "github" }) --}}
    <fieldset>
        <legend>Links</legend>
        <div id="links-list"></div>
        <div>
            <input id="new-link-key" placeholder="key (eg. repo, live)" />
            <input id="new-link-url" placeholder="url" />
            <button type="button" onclick="addLink()">Add link</button>
        </div>
    </fieldset>

    {{-- Milestones (repeatable) --}}
    <fieldset>
        <legend>Milestones</legend>
        <div id="milestones-list"></div>
        <div>
            <input id="new-milestone-title" placeholder="title" />
            <input id="new-milestone-date" type="date" />
            <button type="button" onclick="addMilestone()">Add milestone</button>
        </div>
    </fieldset>

    {{-- Tech stacks --}}
    <fieldset>
        <legend>Tech stacks</legend>

        {{-- provide example techs if controller didn't --}}
        @php
            if (!isset($techs)) {
            $techs = [
                ["ID" => 1, "tech_icon_url" => null, "tech_name" => "Laravel", "tech_color" => "#F55247"],
                ["ID" => 2, "tech_icon_url" => null, "tech_name" => "PostgreSQL", "tech_color" => "#336791"],
                ["ID" => 3, "tech_icon_url" => null, "tech_name" => "Vercel", "tech_color" => "#000000"],
            ];
            }
        @endphp

        <div id="tech-list"></div>

        <div>
            <label for="existing-tech-select">Choose existing tech</label>
            <select id="existing-tech-select">
            <option value="">-- select tech --</option>
            @foreach($techs as $tech)
                <option value="{{ $tech['ID'] }}"
                    data-name="{{ $tech['tech_name'] }}"
                    data-color="{{ $tech['tech_color'] ?? '#000000' }}">
                {{ $tech['tech_name'] }}
                </option>
            @endforeach
            </select>

            {{-- keep these inputs so existing addTech() JS still works;
             they will be populated when selecting from the dropdown --}}
            <input id="new-tech-name" placeholder="tech name (eg. Laravel)" />
            <input id="new-tech-color" type="color" value="#000000" />

            <button type="button" onclick="addTech()">Add tech</button>
        </div>

        <script>
            (function(){
            const sel = document.getElementById('existing-tech-select');
            const nameIn = document.getElementById('new-tech-name');
            const colorIn = document.getElementById('new-tech-color');
            if (!sel || !nameIn || !colorIn) return;
            sel.addEventListener('change', function(){
                const opt = this.options[this.selectedIndex];
                nameIn.value = opt.dataset.name || '';
                colorIn.value = opt.dataset.color || '#000000';
            });
            // initialize if a tech is present
            if (sel.options.length > 1) sel.selectedIndex = 1, sel.dispatchEvent(new Event('change'));
            })();
        </script>
    </fieldset>

    {{-- Collaborators --}}
    <fieldset>
        <legend>Collaborators</legend>
        <div id="collaborators-list"></div>
        <div>
            <input id="new-collab-id" placeholder="user id" />
            <input id="new-collab-name" placeholder="user name" />
            <input id="new-collab-role" placeholder="role (eg. DevOps)" />
            <button type="button" onclick="addCollaborator()">Add collaborator</button>
        </div>
    </fieldset>

    {{-- Hidden JSON payload fields --}}
    <input type="hidden" id="project_links" name="project_links">
    <input type="hidden" id="project_milestone" name="project_milestone">
    <input type="hidden" id="project_tech_stacks" name="project_tech_stacks">
    <input type="hidden" id="collaborators" name="collaborators">

    <div>
        <button type="submit">Create project</button>
    </div>
</form>

<hr>

<section>
    <h4>Payload preview</h4>
    <pre id="payload-preview" style="white-space:pre-wrap; background:#f6f8fa; padding:10px;"></pre>
</section>

<script>
    // In-memory collections
    let links = {}; // mapping key -> url
    let milestones = []; // { title, date }
    let techStacks = []; // { ID (optional), tech_name, tech_color, tech_icon_url (optional) }
    let collaborators = []; // { ID (optional), user_name, pivot: { role } }

    // Render helpers
    function renderLinks() {
        const el = document.getElementById('links-list');
        el.innerHTML = '';
        Object.keys(links).forEach(k => {
            const div = document.createElement('div');
            div.textContent = `${k}: ${links[k]} `;
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.textContent = 'Remove';
            btn.onclick = () => { delete links[k]; renderLinks(); updatePreview(); };
            div.appendChild(btn);
            el.appendChild(div);
        });
    }

    function addLink() {
        const key = document.getElementById('new-link-key').value.trim();
        const url = document.getElementById('new-link-url').value.trim();
        if (!key || !url) return;
        links[key] = url;
        document.getElementById('new-link-key').value = '';
        document.getElementById('new-link-url').value = '';
        renderLinks();
        updatePreview();
    }

    function renderMilestones() {
        const el = document.getElementById('milestones-list');
        el.innerHTML = '';
        milestones.forEach((m, i) => {
            const div = document.createElement('div');
            div.textContent = `${m.title} — ${m.date} `;
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.textContent = 'Remove';
            btn.onclick = () => { milestones.splice(i,1); renderMilestones(); updatePreview(); };
            div.appendChild(btn);
            el.appendChild(div);
        });
    }

    function addMilestone() {
        const title = document.getElementById('new-milestone-title').value.trim();
        const date = document.getElementById('new-milestone-date').value;
        if (!title) return;
        milestones.push({ title, date: date || null });
        document.getElementById('new-milestone-title').value = '';
        document.getElementById('new-milestone-date').value = '';
        renderMilestones();
        updatePreview();
    }

    function renderTech() {
        const el = document.getElementById('tech-list');
        el.innerHTML = '';
        techStacks.forEach((t, i) => {
            const div = document.createElement('div');
            const colorSwatch = document.createElement('span');
            colorSwatch.style.display = 'inline-block';
            colorSwatch.style.width = '12px';
            colorSwatch.style.height = '12px';
            colorSwatch.style.background = t.tech_color || '#000';
            colorSwatch.style.marginRight = '6px';
            div.appendChild(colorSwatch);
            div.appendChild(document.createTextNode(`${t.tech_name} `));
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.textContent = 'Remove';
            btn.onclick = () => { techStacks.splice(i,1); renderTech(); updatePreview(); };
            div.appendChild(btn);
            el.appendChild(div);
        });
    }

    function addTech() {
        const name = document.getElementById('new-tech-name').value.trim();
        const color = document.getElementById('new-tech-color').value;
        if (!name) return;
        techStacks.push({ ID: null, tech_icon_url: null, tech_name: name, tech_color: color });
        document.getElementById('new-tech-name').value = '';
        renderTech();
        updatePreview();
    }

    function renderCollaborators() {
        const el = document.getElementById('collaborators-list');
        el.innerHTML = '';
        collaborators.forEach((c, i) => {
            const div = document.createElement('div');
            div.textContent = `${c.ID || 'id?'} — ${c.user_name} (${c.pivot.role}) `;
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.textContent = 'Remove';
            btn.onclick = () => { collaborators.splice(i,1); renderCollaborators(); updatePreview(); };
            div.appendChild(btn);
            el.appendChild(div);
        });
    }

    function addCollaborator() {
        const idRaw = document.getElementById('new-collab-id').value.trim();
        const id = idRaw ? parseInt(idRaw, 10) : null;
        const name = document.getElementById('new-collab-name').value.trim();
        const role = document.getElementById('new-collab-role').value.trim();
        if (!name) return;
        collaborators.push({ ID: id, user_name: name, user_desc: null, user_bg_color: null, user_fg_color: null, user_accent_color: null, pivot: { role: role || null } });
        document.getElementById('new-collab-id').value = '';
        document.getElementById('new-collab-name').value = '';
        document.getElementById('new-collab-role').value = '';
        renderCollaborators();
        updatePreview();
    }

    // Build preview and prepare hidden inputs before submit
    function preparePayload() {
        // links: keep as object mapping
        document.getElementById('project_links').value = JSON.stringify(links);

        // milestones as array
        document.getElementById('project_milestone').value = JSON.stringify(milestones.length ? milestones : null);

        // tech stacks array
        document.getElementById('project_tech_stacks').value = JSON.stringify(techStacks);

        // collaborators array
        document.getElementById('collaborators').value = JSON.stringify(collaborators);

        // update preview one last time
        updatePreview();
        // allow form to submit
        return true;
    }

    function collectFormForPreview() {
        return {
            PROJECT_STATUS_ID: document.getElementById('PROJECT_STATUS_ID').value || null,
            project_name: document.getElementById('project_name').value || null,
            project_desc: document.getElementById('project_desc').value || null,
            project_start: document.getElementById('project_start').value || null,
            project_date: document.getElementById('project_date').value || null,
            project_links: Object.keys(links).length ? links : null,
            project_milestone: milestones.length ? milestones : null,
            project_status: null, // populate on backend if needed
            project_tech_stacks: techStacks,
            collaborators: collaborators
        };
    }

    function updatePreview() {
        document.getElementById('payload-preview').textContent = JSON.stringify(collectFormForPreview(), null, 2);
    }

    // keep preview live
    document.querySelectorAll('#project_name, #project_desc, #project_start, #project_date, #PROJECT_STATUS_ID').forEach(el => {
        el.addEventListener('input', updatePreview);
        el.addEventListener('change', updatePreview);
    });

    // initial preview
    updatePreview();
</script>