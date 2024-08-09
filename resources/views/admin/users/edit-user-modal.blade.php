<div>
    <form id="editUserForm">
            <input type="hidden" name="id" value="{{ $user->id }}"/>
            <x-text-input
                    id="name"
                    name="name"
                    type="text"
                    class="form-control"
                    placeholder="Username"
                    value="{{ $user->name }}"
                    required
            />
            <br/>
            <input
                    id="name"
                    name="email"
                    type="text"
                    class="form-control"
                    placeholder="Email"
                    value="{{ $user->email }}"
                    required
            />
            Role:
            <select name="role" class="form-control">
                <option value=""></option>
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}"
                            @if ($user->hasRole($role->name)) selected @endif>{{ $role->name }}</option>
                @endforeach
            </select>
            <input type="submit" hidden />
    </form>
</div>
<script>
    $("#editUserForm").on("submit", function (event)
    {
        event.preventDefault();
        $.post("{{ route('users_edit') }}", $(this).serializeArray()).done(function (data)
        {
            window.location = "";
        });
    });
</script>
