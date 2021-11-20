@section('box')

    <x-modal id="myModal" action="{{route('product-category.store')}}" title="Add New Product Category" icon="grid5">
        <x-input name="code" label="Serial Number" value="{{mt_rand()}}" required="required" />
        <x-input name="name" label="Product Category Name" required="required" />
    </x-modal>


    <x-modal id="ediModal" action="#" title="Edit Product Category" bg="success" icon="pencil6">
        @method('PUT')
        <x-input name="code" label="Serial Number" required="required" />
        <x-input name="name" label="Product Category Name" required="required" />
    </x-modal>

@endsection
