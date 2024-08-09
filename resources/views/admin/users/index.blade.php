<x-app-layout>
    @section('title', 'Users')
    <table class="table table">
        <thead>
        <tr>
            <td>
                Name
            </td>
            <td>
                Email
            </td>
            <td>
                Actions
            </td>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr>
                <td>
                    {{ $user->name }}
                </td>
                <td>
                    {{ $user->email }}
                </td>
                <td>
                    <a href="javascript:editUserModal({{ $user->id }})">Edit</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
</x-app-layout>
<script>
    function editUserModal(id)
    {
        $.post("{{ route('users_editModal') }}", {id: id}).done(function (data)
        {
            bootbox.confirm({
                title: 'Edit User',
                message: data,
                size: 'large',
                buttons: {
                    cancel:
                    {
                        label: '<i class="fa fa-times"></i> Cancel'
                    },
                    confirm:
                    {
                        label: '<i class="fa fa-check"></i> Save'
                    }
                },
                callback: function (result)
                {
                    if (result)
                        $("#editUserForm").submit();
                }
            });
        });
    }
</script>
