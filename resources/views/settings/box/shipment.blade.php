@section('box')

    <x-modal id="myModal" action="{{route('shipment.store')}}" title="Add New Shipment Option" icon="grid5">
        <x-input name="name" label="Shipment Name" required="required" />
        <x-input name="shipping_company" label="Shipment Company"/>
        <x-input name="description" label="Descriptions"/>
    </x-modal>


    <x-modal id="ediModal" action="#" title="Edit Shipment Option" bg="success" icon="pencil6">
        @method('PUT')
        <x-input name="name" label="Shipment Name" required="required" />
        <x-input name="shipping_company" label="Shipment Company"/>
        <x-input name="description" label="Descriptions"/>
    </x-modal>

@endsection