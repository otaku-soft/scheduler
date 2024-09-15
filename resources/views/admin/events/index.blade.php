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
                        <a href = "#">Edit</a>
                        <a href = "#">Set Times</a>
                        <a href = "#">Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
        {{ $scopeEvents->links() }}
    @else
        No Events
        <br/><br/>
    @endif
    <button class="btn btn-primary" onclick="addEvent()">Add Event</button>
 </x-app-layout>
<script>
    const getList = function ()
    {
        $.post("{{ route('events_eventList') }}").done(function (html)
        {
            $("#eventList").html(html);
        });
    }
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
                    $("#addEventButton").click();
                    else
                    window.location = "";
                }
            });
        });
    }
    getList();
</script>