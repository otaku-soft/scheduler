<form id="addStoreForm">
    <input type="text" class="form-control" name="name" placeholder="Name" required/> <br/>
    <input type="text" class="form-control" name="address" placeholder="Address" required/> <br/>
    <input type="text" class="form-control" name="address2" placeholder="Address2"/> <br/>
    <input type="text" class="form-control" name="city" placeholder="City" required style="width:49%;display:inline"/>
    <select class="form-control" required style="width:50%;display:inline" name="state">
        @foreach ($states as $state => $description)
            <option value="{{ $state }}" @if ($state === "UT") selected @endif>{{ $description }}</option>
        @endforeach
    </select> <br/><br/>
    <input type="text" class="form-control" name="zip" placeholder="Zip" required style="width:49%;display:inline"/>
    <input type="text" class="form-control" name="zip2" placeholder="Zip2" required style="width:50%;display:inline"/>
    <br/><br/>
    <input type="text" class="form-control" name="phone" placeholder="Phone" required/> <br/>
    <input type="text" class="form-control" name="email" placeholder="Email" required/> <br/>
    <input type="submit" hidden/>
</form>
<script>
    $("#addStoreForm").on("submit", function (event)
    {
        event.preventDefault();
        $.post("{{ route('stores_addStore') }}", $(this).serializeArray()).done(function (data)
        {
            if ("success" in data && data.success)
                window.location = "";
            else
                alert('An error occured');
        });
    });
</script>
