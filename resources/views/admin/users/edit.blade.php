<div class="form-group">
    <label for="role">Rola:</label>
    <select class="form-control" name="role" id="role">
        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="employee" {{ $user->role === 'employee' ? 'selected' : '' }}>Pracownik</option>
        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Użytkownik</option>
    </select>
</div>