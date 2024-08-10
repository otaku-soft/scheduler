<form id="editStoreForm">
    <input type="hidden" name="id" value="{{ $store->id }}" />
    <label>Name</label>
    <input type="text" class="form-control" name="name" placeholder="Name" value="{{ $store->name }}" required/> <br/>
    <label>Address</label>
    <input type="text" class="form-control" name="address" placeholder="Address" value="{{ $store->address }}" required/> <br/>
    <label>Address 2</label>
    <input type="text" class="form-control" name="address2" placeholder="Address2" value="{{ $store->address2 }}" /> <br/>
    <div class="row">
        <div class="col-md-6">
            <label>City</label>
            <input type="text" class="form-control" name="city" placeholder="City" required  value="{{ $store->city }}" />
            <br/>
            <label>Zip</label>
            <input type="text" class="form-control" name="zip" placeholder="Zip" required  value="{{ $store->zip }}" />
        </div>
        <div class="col-md-6">
            <label for="state">State</label>
            <select class="form-control" required  name="state">
                @foreach ($states as $state => $description)
                    <option value="{{ $state }}" @if ($state === $store->state) selected @endif>{{ $description }}</option>
                @endforeach
            </select>
            <br/>
            <label>Zip 2</label>
            <input type="text" class="form-control" name="zip2" placeholder="Zip 2" required value="{{ $store->zip2 }}"  />
        </div>
    </div>
    <br/>
    <label>Phone</label>
    <input type="text" class="form-control" name="phone" placeholder="Phone" required  value="{{ $store->phone }}"  /> <br/>
    <label>Email</label>
    <input type="text" class="form-control" name="email" placeholder="Email" required  value="{{ $store->email }}"  /> <br/>
    <input type="submit" hidden/>
</form>
<script>
    $("#editStoreForm").on("submit", function (event)
    {
        event.preventDefault();
        $.post("{{ route('stores_editStore') }}", $(this).serializeArray()).done(function (data)
        {
            if ("success" in data && data.success)
                window.location = "";
            else
                alert('An error occured');
        });
    });
</script>