<x-app-layout>
    @section('title', 'Roles')

    <ul id="sectionList" class="list-group">
        @foreach ($roles as $role)
            <li class="list-group-item">
                {{ $role->name }}
                @if ($role->name !== "admin")
                    <a href="#" style="float:right;margin-right:5px"
                       onclick="editRoleModal({{ $role->id }})">
                        Edit
                    </a>
                @endif
            </li>
        @endforeach
    </ul>
    <br/><br/>
    <button class="btn btn-primary" onclick="addRole()">
        Add Role
    </button>
</x-app-layout>

<script>
    const addRole = function ()
    {
        $.post("{{ route('roles_addRoleModal') }}").done(function (data)
        {
            bootbox.confirm({
                title: 'Add Role',
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
                        $("#addRoleForm").submit();
                }
            });
        });
    }
    const editRoleModal = function(id)
    {
        $.post("{{ route('roles_editRoleModal') }}",{id:id}).done(function (data)
        {
            bootbox.confirm({
                title: 'Edit Role',
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
                        $("#editRoleForm").submit();
                }
            });
        });
    }
</script>
