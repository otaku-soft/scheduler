<x-app-layout>
    @section('title', 'Rooms')
    @if (count($rooms) > 0)
        <table class="table table">
            <thead>
            <tr>
                <td>
                    Name
                </td>
                <td>
                    Slug
                </td>
                <td>
                    Actions
                </td>
            </tr>
            </thead>
            <tbody>
            @foreach ($rooms as $room)
                <tr>
                    <td>
                        {{ $room->name  }}
                    </td>
                    <td>
                        {{ $room->slug }}
                    </td>
                    <td>
                        <a href = "#" onclick="javascript:editRoomModal({{ $room->id }})">Edit</a> <a href = "#"
                                onclick="deleteRoomModal({{ $room->id }})">Delete</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        There are no Rooms
    @endif
    <br/><br/>
    <button class="btn btn-primary" onclick="addRoomModal()">Add Room</button>
    @if (count($deletedRooms) > 0)
        <br/>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Recover Stores</h1>
        </div>
        <table class="table table">
            <thead>
            <tr>
                <td colspan="2">
                    Name
                </td>
            </tr>
            </thead>
            <tbody>
            @foreach ($deletedRooms as $room)
                <tr>
                    <td>
                        {{ $room->name }}
                    </td>
                    <td>
                        <a href="#" onclick="restoreRoom({{ $room->id }})">Recover</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</x-app-layout>

<script>
    const addRoomModal = function ()
    {
        $.post("{{ route('rooms_addRoomModal') }}").done(function (data)
        {
            bootbox.confirm({
                title: 'Add Store',
                message: data,
                size: 'large',
                buttons: {
                    cancel:
                    {
                        label: '<i class="fa fa-times"></i> Cancel'
                    },
                    confirm:
                    {
                        label: '<i class="fa fa-check"></i> Add'
                    }
                },
                callback: function (result)
                {
                    if (result)
                        $("#addRoomForm").submit();
                    return !result;
                }
            });
        });
    }
    const editRoomModal = function (id)
    {
        $.post("{{ route('rooms_editRoomModal') }}", {id: id}).done(function (data)
        {
            bootbox.confirm({
                title: 'Edit Room',
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
                        $("#editRoomForm").submit();
                    return !result;
                }
            });
        });
    }
    const deleteRoomModal = function (id)
    {
        $.post("{{ route('rooms_deleteRoomModal') }}", {id: id}).done(function (data)
        {
            bootbox.confirm({
                title: 'Delete Room',
                message: data,
                size: 'small',
                buttons: {
                    cancel:
                    {
                        label: '<i class="fa fa-times"></i> Cancel'
                    },
                    confirm:
                    {
                        label: '<i class="fa fa-check"></i> Delete'
                    }
                },
                callback: function (result)
                {
                    if (result)
                    {
                        $.post("{{ route('rooms_deleteRoom') }}", {id: id}).done(function (data)
                        {
                            window.location = "";
                        });
                    }
                    return !result;
                }
            });
        });
    }
    const restoreRoom = function (id)
    {
        $.post("{{ route('rooms_restoreRoom') }}", {id: id}).done(function (data)
        {
            window.location = "";
        });
    }
</script>