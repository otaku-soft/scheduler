<x-app-layout>
    @section('title', 'Events')
    <div id="eventList"></div>
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
                    return !result;
                }
            });
        });
    }
    getList();
</script>