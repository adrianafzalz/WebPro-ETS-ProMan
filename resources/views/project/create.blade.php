<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Create New Project</title>

  {{-- Fonts --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  {{-- Styles --}}
  <link rel="stylesheet" href="{{ asset('CSS/form.css') }}">
</head>

<body>
  <div class="modal">
    <div class="modal-content">
      <h2>Create New Project</h2>
      <p class="subtitle">Fill in the details to create a new project</p>

      {{-- Laravel form --}}
      <form method="POST" action="{{ route('project.create.attempt') }}">
        @csrf

        <label for="name">Project Name *</label>
        <input id="name" name="name" type="text" placeholder="Enter project name" value="{{ old('name') }}" required />

        <label for="status">Status *</label>
        <select id="status" name="status" required>
          <option value="" disabled selected>Select project status</option>
          <option value="1" {{ old('status') == 'Planning' ? 'selected' : '' }}>Planning</option>
          <option value="2" {{ old('status') == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
          <option value="3" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
        </select>

        <div class="row">
          <div class="col">
            <label for="start_date">Start Date *</label>
            <input id="start_date" name="start_date" type="date" value="{{ old('start_date') }}" required />
          </div>
          <div class="col">
            <label for="end_date">End Date *</label>
            <input id="end_date" name="end_date" type="date" value="{{ old('end_date') }}" required />
          </div>
        </div>

        <label for="description">Description *</label>
        <textarea id="description" name="description" placeholder="Write the description of your project" required>{{ old('description') }}</textarea>

        <div class="row">
          <div class="col">
            <label for="links">Project link</label>
            <div class="inline-input">
              <input id="links" name="links[]" type="text" placeholder="Live Web" />
              <button type="button" class="add-btn" onclick="addLinkInput()">+</button>
            </div>
          </div>

          <div class="col">
            <label for="technologies">Technology</label>
            <div class="inline-input">
              <select id="technologies" name="technologies[]">
                <option value="" disabled selected>Select Tech</option>
                @foreach($allTech as $techoption)
                    <option value="{{$techoption->ID}}">{{$techoption->tech_name}}</option>
                @endforeach
                {{-- <option>Laravel</option>
                <option>React</option>
                <option>Python</option> --}}
              </select>
              <button type="button" class="add-btn" onclick="addTechSelect()">+</button>
            </div>
          </div>
        </div>

        <label for="collaborators">Collaborator</label>
        <div class="inline-input">
          <input id="collaborators" name="collaborators[]" type="text" placeholder="Enter Collaborator" />
          <button type="button" class="add-btn" onclick="addCollaborator()">+</button>
        </div>

        <div class="actions">
          <a href="{{ route('user.me') }}" class="cancel-btn">Cancel</a>
          <button type="submit" class="create-btn">Create Project</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // JS untuk menambah input baru (link, tech, collaborator)
    function addLinkInput() {
      const div = document.createElement('div');
      div.classList.add('inline-input');
      div.innerHTML = '<input name="links[]" type="text" placeholder="Live Web" /> <button type="button" class="add-btn" onclick="this.parentNode.remove()">−</button>';
      document.querySelector('#links').parentNode.parentNode.appendChild(div);
    }

    function addTechSelect() {
      const div = document.createElement('div');
      div.classList.add('inline-input');
      div.innerHTML = `
        <select name="technologies[]">
          <option value="" disabled selected>Select Tech</option>
          <option>Laravel</option>
          <option>React</option>
          <option>Python</option>
        </select>
        <button type="button" class="add-btn" onclick="this.parentNode.remove()">−</button>
      `;
      document.querySelector('#technologies').parentNode.parentNode.appendChild(div);
    }

    function addCollaborator() {
      const div = document.createElement('div');
      div.classList.add('inline-input');
      div.innerHTML = '<input name="collaborators[]" type="text" placeholder="Enter Collaborator" /> <button type="button" class="add-btn" onclick="this.parentNode.remove()">−</button>';
      document.querySelector('#collaborators').parentNode.parentNode.appendChild(div);
    }
  </script>
</body>
</html>
