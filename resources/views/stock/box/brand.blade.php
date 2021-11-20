@section('box')

    <x-modal id="myModal" action="{{route('brand.store')}}" title="Add New Product Brand" icon="grid5">
        <x-input name="name" label="Brand Name" required="required" />
        <x-input name="description" label="Brand Description"/>
    </x-modal>


    <x-modal id="ediModal" action="#" title="Edit Product Brand" bg="success" icon="pencil6">
        @method('PUT')
        <x-input name="name" label="Brand Name" required="required" />
        <x-input name="description" label="Brand Description"/>
    </x-modal>

@endsection