<form id="addRoleForm">
    <input
            id="name"
            name="name"
            type="text"
            placeholder="Name"
            class = "form-control"
            required
    />
    <input type="submit" hidden />
</form>
<script>
$("#addRoleForm").on("submit", function (event)
{
    event.preventDefault();
    $.post("{{ route('roles_addRole') }}", $(this).serializeArray()).done(function (data)
    {
        window.location = "";
    });
});
</script>