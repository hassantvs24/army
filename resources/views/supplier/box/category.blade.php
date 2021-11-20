@section('box')

    <x-modal id="myModal" action="{{route('supplier-category.store')}}" title="Add New Supplier Category" icon="grid5">
        <x-input name="code" label="Serial Number" value="{{mt_rand()}}" required="required" />
        <x-input name="name" label="Supplier Category Name" required="required" />
    </x-modal>


    <x-modal id="ediModal" action="#" title="Edit Supplier Category" bg="success" icon="pencil6">
        @method('PUT')
        <x-input name="code" label="Serial Number" required="required" />
        <x-input name="name" label="Supplier Category Name" required="required" />
    </x-modal>

@endsection
