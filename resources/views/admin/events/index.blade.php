<x-app-layout>
    @section('title', 'Events')
    @if (count($events) > 0)
    <table class="table table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($events as $event)
                <tr>
                    <td>
                        {{ $event->name }}
                    </td>
                    <td>
                        <a href = "#" onclick="editEvent({{ $event->id }})">Edit</a>
                        <a href = "#">Set Times</a>
                        <a href = "#">Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @else
        No Events
        <br/><br/>
    @endif
    {{ $scopeEvents->links() }}
    <button class="btn btn-primary" onclick="addEvent()">Add Event</button>
 </x-app-layout>
<script>
    function addEvent()
    {
        $.post("{{ route('events_addEventModal') }}").done(function (html)
        {
            bootbox.confirm({
                title: 'Add Event',
                message: html,
                size: 'medium',
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
                    $("#saveEventButton").click();
                    else
                    window.location = "";
                }
            });
        });
    }
    function editEvent(id)
    {
        $.post("{{ route('events_editEventModal') }}",{id:id}).done(function (html)
        {
            bootbox.confirm({
                title: 'Edit Event',
                message: html,
                size: 'medium',
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
                        $("#saveEventButton").click();
                    else
                        window.location = "";
                }
            });
        });
    }
</script>