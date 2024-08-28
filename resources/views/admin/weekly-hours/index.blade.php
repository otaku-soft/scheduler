<x-app-layout>
    <ul class="list-group">
        @foreach ($days as $day)
            <li class="list-group-item">
                <h3>{{ $day }}</h3>
                <ul class="list-group">
                    @foreach ($hours as $hour)
                        <li class="list-group-item">
                            <input type="checkbox" name="hour" data-hour="{{ $hour }}" /> @include('admin.weekly-hours.hour',['hour' => $hour])
                            - @include('admin.weekly-hours.hour',['hour' => $hour+1])
                            @foreach ($minutes as $minute)
                                @if ($minute % 10 === 0)
                                    @php
                                        $localMinute = $minute
                                    @endphp
                                    <ul class="list-group" style="padding-top:10px;padding-bottom:10px;margin-left:1%" data-hour="{{ $hour }}">
                                        <li class="list-group-item">
                                            <input type="checkbox"  name="minute" data-minute="{{ $minute }}"/> {{ $minute }} - {{ $minute +10  }}
                                            <ul class="list-group" style="margin-left:1%;" data-minute="{{ $minute }}">
                                                <li class="list-group-item">
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <span style="padding-right:10px"><input type="checkbox" name="localMinute"/> {{ $localMinute  }} - {{ $localMinute + 1 }} </span>
                                                        @php
                                                            $localMinute++
                                                        @endphp
                                                    @endfor
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                @endif
                            @endforeach
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
    <br/>
    <button class="btn btn-primary">Save</button>
</x-app-layout>


<script>
    $("[name=hour]").click(function(){
        let hour = $(this).data("hour");
        $(`ul[data-hour=${hour}]`).toggle(!$(this).is(":checked"));
    });
    $("[name=minute]").click(function(){
        let minute = $(this).data("minute");
        $(`ul[data-minute=${minute}]`).toggle(!$(this).is(":checked"));
    });
</script>