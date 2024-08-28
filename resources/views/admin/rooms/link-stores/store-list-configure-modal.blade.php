<form id="configureStoreRoomForm">
    Active: <input type="checkbox" id="activeStore" @if ($active)checked @endif /><br/>
    Default Scoring: <input type="checkbox" id="defaultScoring" @if ($defaultScoring)checked @endif onclick="defaultScoringToggle()" />
    <br/><br/>
    <div id="pricingSections">
        @include('admin.rooms.shared.pricing-sections')
    </div>
</form>

<script>
    function defaultScoringToggle()
    {
        $("#pricingSections").toggle(!$("#defaultScoring").is(":checked"))
    }
    defaultScoringToggle();
    $("#configureStoreRoomForm").on("submit", function (event)
    {
        event.preventDefault();
        let prices = new Array();
        $(".priceField").each(function (index)
        {
            prices.push({personNumber: $(this).data("personNumber"), type: $(this).data('type'), price: $(this).val()});
        });
        $.post("{{ route('rooms_storeListConfigureSave') }}", {roomId: {{ $roomId }}, storeId: {{ $storeId }}, active: $("#activeStore").is(":checked") ? 1 : 0, prices: prices, defaultScoring: $("#defaultScoring").is(":checked") ? 1 : 0}).done(function (data)
        {
            if ("success" in data && data.success)
                window.location = "";
            else
                alert('An error occured');

        });
    });
</script>