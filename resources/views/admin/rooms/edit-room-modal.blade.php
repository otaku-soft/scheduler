<form id="editRoomForm">
    <input type="hidden" name="id" value="{{ $room->id }}" />
    <label>Name</label>
    <input type="text" class="form-control" name="name" placeholder="Name" value="{{ $room->name }}" required/> <br/>
    <input type="submit" hidden/>
</form>
<script>
    $("#editRoomForm").on("submit", function (event)
    {
        event.preventDefault();
        $.post("{{ route('rooms_editRoom') }}", $(this).serializeArray()).done(function (data)
        {
            if ("success" in data && data.success)
                window.location = "";
            else
                alert('An error occured');
        });
    });
</script>