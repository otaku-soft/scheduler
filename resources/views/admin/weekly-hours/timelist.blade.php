@if (count($times) > 0)
<table class="table table">
    <thead>
        <tr>
            <th>Starting Time</th>
            <th>Ending Time</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($times as $time)
            <tr>
                <td> {{ date("g:i A",strtotime($time->starting_time)) }}</td>
                <td> {{ date("g:i A",strtotime($time->ending_time)) }}</td>
                <td> <a href="#" onclick="editTimeModal({{ $time->id }})">Edit</a> <a href="#"onclick="deleteTimeModal({{ $time->id }})"  >Delete</a></td>
            </tr>
        @endforeach

    </tbody>
</table>
@endif