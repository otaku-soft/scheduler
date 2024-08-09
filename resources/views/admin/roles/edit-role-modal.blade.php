<form id="editRoleForm">
    <input type="hidden" name="id" value="{{ $role->id }}"/>
    <input
            id="name"
            name="name"
            type="text"
            class="form-control"
            placeholder="Name"
            value="{{ $role->name }}"
            required
    />
    <input type="submit" hidden />
</form>
<script>
    $("#editRoleForm").on("submit", function (event)
    {
        event.preventDefault();
        $.post("{{ route('roles_editRole') }}", $(this).serializeArray()).done(function (data)
        {
            window.location = "";
        });
    });
</script>
