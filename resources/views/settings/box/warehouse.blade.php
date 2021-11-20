@section('box')

    <x-modal id="myModal" action="{{route('warehouse.store')}}" title="Add New Warehouse" icon="grid5">
        <x-input name="name" label="Warehouse Name" required="required" />
        <x-input name="proprietor" label="Proprietor Name" value="{{Auth::user()->name}}" required="required" />
        <x-input name="contact" label="Contact Number" required="required" />
        <x-input name="address" label="Address"  required="required" />
        <x-input name="email" type="email" label="Email" />
        <x-input name="phone" label="Phone Number" />
        <x-upload name="logo" label="Logo Upload" accept="image/png, image/jpeg" />
    </x-modal>


    <x-modal id="ediModal" action="#" title="Edit Warehouse" bg="success" icon="pencil6">
        @method('PUT')

        <x-input name="name" label="Warehouse Name" required="required" />
        <x-input name="proprietor" label="Proprietor Name" value="{{Auth::user()->name}}" required="required" />
        <x-input name="contact" label="Contact Number" required="required" />
        <x-input name="address" label="Address"  required="required" />
        <x-input name="email" type="email" label="Email" />
        <x-input name="phone" label="Phone Number" />
        <x-upload name="logo" label="Logo Upload" accept="image/png, image/jpeg" />
        <div class="text-center"><img src="" class="imgLogo" alt="Warehouse logo"></div>
    </x-modal>

@endsection