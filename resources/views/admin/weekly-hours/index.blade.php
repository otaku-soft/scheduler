<x-app-layout>
    <ul class="nav nav-tabs">

        @foreach ($days as $day)
            <li class="nav-item">
                <a class="nav-link @if ($loop->first) active @endif" onclick="showSection('{{ $day }}')" href="#"
                   data-day="{{ $day }}">{{ $day }}</a>
            </li>
        @endforeach
    </ul>
    @foreach ($days as $day)
        <div data-day="{{ $day }}" class="day">
            <br/>
            <div class="scheduleList" data-day="{{ $day }}">

            </div>
        </div>
    @endforeach
    <b>Add a time</b>
    <div class="row">
        <div class="col">
            Start
            <input type="text" class="timepicker form-control" id="startingTime"/>
        </div>
        <div class="col">
            End
            <input type="text" class="timepicker form-control" id="endingTime"/>
        </div>
    </div>
    <br/>
    <button class="btn btn-primary"
            onclick="addTime($('.day:visible').data('day'),$('#startingTime').val(),$('#endingTime').val())">Save
    </button>
</x-app-layout>

<script>
    $('.timepicker').timepicker({
        timeFormat: 'h:mm p',
        interval: 5,
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });
    const getList = function (day)
    {
        $.post("{{ route('weeklyHours_timelist') }}", {day: day}).done(function (html)
        {
            $(`.scheduleList[data-day=${day}]`).html(html);
        });
    }
    const showSection = function (day)
    {
        $('.day').hide();
        $('.nav-link').removeClass('active');
        $(`.nav-link[data-day=${day}]`).addClass('active');
        $(`.day[data-day=${day}]`).show();
        getList(day);
    }
    const addTime = function (day, startingTime, endingTime)
    {
        let time = new Object();
        time.day = day;
        time.startingTime = startingTime;
        time.endingTime = endingTime;
        $.post("{{ route('weeklyHours_addTime') }}", time).done(function (data)
        {
            getList(day);
        });
    }
    const editTimeModal = function (id)
    {
        $.post("{{ route('weeklyHours_editTimeModal') }}", {id: id}).done(function (data)
        {
            bootbox.confirm({
                title: 'Edit Time',
                message: data,
                size: 'small',
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
                    {
                        let time = new Object();
                        time.startingTime = $("#startingTimeModal").val();
                        time.endingTime = $("#endingTimeModal").val();
                        time.id = id;
                        $.post("{{ route('weeklyHours_editTime') }}", time).done(function (data)
                        {
                            if (data.success)
                            {
                                getList($('.day:visible').data('day'));
                                bootbox.hideAll()
                            }
                        });
                    }
                    return !result;
                }
            });
        });
    }
    const deleteTimeModal = function (id)
    {
        $.post("{{ route('weeklyHours_deleteTimeModal') }}", {id: id}).done(function (data)
        {
            bootbox.confirm({
                title: 'Delete Time',
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
                        $.post("{{ route('weeklyHours_deleteTime') }}", {id: id}).done(function (data)
                        {
                            if (data.success)
                            {
                                getList($('.day:visible').data('day'));
                                bootbox.hideAll()
                            }
                        });
                    }
                    return !result;
                }
            });
        });
    }
    showSection('{{ current($days) }}');
</script>