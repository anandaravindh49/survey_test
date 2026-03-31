<h2>Create Role</h2>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<form method="POST" action="{{ route('roles.store') }}">
    @csrf

    <input type="text" name="name" placeholder="Role name" required>
    <br><br>

    <input type="text" name="display_name" placeholder="Display name" required>
    <br><br>

    <input type="text" name="description" placeholder="Description">
    <br><br>

    <button type="submit">Save</button>
</form>