<x-app-layout>
    @section('title', "Store List for $room->name")
    @if (count($stores) > 0)
        <table class="table table">
            <thead>
            <tr>
                <td>
                    Name
                </td>
                <td>
                    Active
                </td>
                <td>
                    Actions
                </td>
            </tr>
            </thead>
            <tbody>
            @foreach ($stores as $store)
                <tr>
                    <td>
                        {{ $store->name }}
                    </td>
                    <td>
                        @if (array_key_exists($store->id,$linkedStoreIds))
                            Yes
                        @else
                            No
                        @endif
                    </td>
                    <td>
                        <a href="#" onclick="javascript:storeListConfigureModal({{ $room->id }},{{$store->id }})">Configure</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        There are no stores

    @endif
    {{ $stores->links() }}
</x-app-layout>


<script>
    const storeListConfigureModal = function (roomId, storeId)
    {
        $.post("{{ route('rooms_storeListConfigureModal') }}",{roomId: roomId,storeId:storeId}).done(function (data)
        {
            bootbox.confirm({
                title: 'Configure store',
                message: data,
                size: 'large',
                buttons: {
                    cancel:
                    {
                        label: '<i class="fa fa-times"></i> Cancel'
                    },
                    confirm:
                    {
                        label: '<i class="fa fa-check"></i> Save'
                    }
                },
                callback: function (result)
                {
                    if (result)
                    {
                        $("#configureStoreRoomForm").submit();
                    }
                    return !result;
                }
            });
        });
    }
</script>
