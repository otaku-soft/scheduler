<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active pricing-tab" aria-current="page" href="#"
           onclick="showPricingSection('private-pricing')" id="private-pricing-tab">Private</a>
    </li>
    <li class="nav-item">
        <a class="nav-link pricing-tab" href="#" onclick="showPricingSection('public-pricing')"
           id="public-pricing-tab">Public</a>
    </li>
</ul>
<div id="private-pricing" class="pricing-section">
    @include('admin.rooms.shared.pricing-table',['prices' => $pricesPrivate])
</div>
<div id="public-pricing" class="pricing-section" style="display:none">
    @include('admin.rooms.shared.pricing-table',['prices' => $pricesPublic])
</div>

<script>
    function showPricingSection(section)
    {
        $(".pricing-section").hide();
        $(`#${section}`).show();
        $(".pricing-tab").removeClass("active");
        $(`#${section}-tab`).addClass("active");
    }
</script>