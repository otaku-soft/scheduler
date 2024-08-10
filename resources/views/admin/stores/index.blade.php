<x-app-layout>
    @section('title', 'Stores')
    @if (count($stores) > 0)
        <table class="table table">
            <thead>
            <tr>
                <td>
                    Name
                </td>
                <td>
                    Address
                </td>
                <td>
                    Slug
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
                        {{ $store->address }} <br/>
                        @isset($address2)
                            {{ $store->address2 }} <br/>
                        @endisset
                        {{ $store->city }}, {{ $store->state }}, {{ $store->zip }} @isset($store->zip2)
                            -{{ $store->zip2 }}
                        @endisset <br/>
                        {{ $store->email }}
                    </td>
                    <td>
                        {{ $store->slug }}
                    </td>
                    <td>
                        <a href="#" onclick="editScoreModal({{ $store->id }})">Edit</a> <a href="#"
                                                                                           onclick="deleteStoreModal({{ $store->id }})">Delete</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $stores->links() }}
    @else
        There are no stores

    @endif
    <br/><br/>
    <button class="btn btn-primary" onclick="addStoreModal()">Add Store</button>
    @if (count($deletedStores) > 0)
        <br/>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Recover Stores</h1>
        </div>
        <table class="table table">
            <thead>
            <tr>
                <td colspan="2">
                    Name
                </td>
            </tr>
            </thead>
            <tbody>
            @foreach ($deletedStores as $store)
                <tr>
                    <td>
                        {{ $store->name }}
                    </td>
                    <td>
                        <a href = "#" onclick="restoreStore({{ $store->id }})">Recover</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</x-app-layout>
<script>
    const addStoreModal = function ()
    {
        $.post("{{ route('stores_addStoreModal') }}").done(function (data)
        {
            bootbox.confirm({
                title: 'Add Store',
                message: data,
                size: 'large',
                buttons: {
                    cancel:
                    {
                        label: '<i class="fa fa-times"></i> Cancel'
                    },
                    confirm:
                    {
                        label: '<i class="fa fa-check"></i> Add'
                    }
                },
                callback: function (result)
                {
                    if (result)
                        $("#addStoreForm").submit();
                    return !result;
                }
            });
        });
    }

    const editScoreModal = function (id)
    {
        $.post("{{ route('stores_editStoreModal') }}", {id: id}).done(function (data)
        {
            bootbox.confirm({
                title: 'Edit Store',
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
                        $("#editStoreForm").submit();
                    return !result;
                }
            });
        });
    }
    const deleteStoreModal = function (id)
    {
        $.post("{{ route('stores_deleteStoreModal') }}", {id: id}).done(function (data)
        {
            bootbox.confirm({
                title: 'Delete Store',
                message: data,
                size: 'small',
                buttons: {
                    cancel:
                    {
                        label: '<i class="fa fa-times"></i> Cancel'
                    },
                    confirm:
                    {
                        label: '<i class="fa fa-check"></i> Delete'
                    }
                },
                callback: function (result)
                {
                    if (result)
                    {
                        $.post("{{ route('stores_deleteStore') }}", {id: id}).done(function (data)
                        {
                            window.location = "";
                        });
                    }
                    return !result;
                }
            });
        });
    }
    const restoreStore = function(id)
    {
        $.post("{{ route('stores_restoreStore') }}", {id: id}).done(function (data)
        {
            window.location = "";
        });
    }
</script>