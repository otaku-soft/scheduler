<form id="addRoomForm">
    <input type="text" class="form-control" name="name" placeholder="Name" required/> <br/>
    <input type="submit" hidden/>
</form>
<script>
    $("#addRoomForm").on("submit", function (event)
    {
        event.preventDefault();
        $.post("{{ route('rooms_addRoom') }}", $(this).serializeArray()).done(function (data)
        {
            if ("success" in data && data.success)
                window.location = "";
            else
                alert('An error occured');
        });
    });
</script>