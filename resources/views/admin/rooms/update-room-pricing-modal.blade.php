<form id="pricingForm">
    @include('admin.rooms.shared.pricing-sections')
</form>
<script>
    $("#pricingForm").on("submit", function (event)
    {
        event.preventDefault();
        let prices = new Array();
        $(".priceField").each(function (index)
        {
            prices.push({personNumber: $(this).data("personNumber"), type: $(this).data('type'), price: $(this).val()});
        });
        $.post("{{ route('rooms_updateRoomPricing') }}", {room_id: {{ $room->id }}, prices: prices}).done(function (data)
        {
            if ("success" in data && data.success)
                window.location = "";
            else
                alert('An error occured');
        });

    });
</script>