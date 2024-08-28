<table class="table table">
    <thead>
    <tr>
        <th># of people</th>
        <th>Price</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($prices as $price)
        <tr>
            <td>
                {{ $price->getPersonNumber() }}
            </td>
            <td>
                <input type = "number" class="form-control priceField" min="0" data-person-number="{{$price->getPersonNumber()}}" data-type="{{$price->getType()}}" name="price" value="{{ $price->getPrice() }}" />
            </td>
        </tr>
    @endforeach
    </tbody>
</table>