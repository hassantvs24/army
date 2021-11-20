@section('box')

    <x-modal id="myModal" action="{{route('units.store')}}" title="Add New Product Units" icon="grid5">
        <x-input name="name" label="Unit Name" required="required" />
        <x-input name="full_name" label="Full Unit Name"/>
    </x-modal>


    <x-modal id="ediModal" action="#" title="Edit Product Units" bg="success" icon="pencil6">
        @method('PUT')
        <x-input name="name" label="Unit Name" required="required" />
        <x-input name="full_name" label="Full Unit Name"/>
    </x-modal>

@endsection