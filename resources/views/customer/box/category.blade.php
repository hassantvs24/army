@section('box')

    <x-modal id="myModal" action="{{route('customer-category.store')}}" title="Add New Customer Category" icon="grid5">
        <x-input name="code" label="Serial Number"  value="{{mt_rand()}}" required="required" />
        <x-input name="name" label="Customer Category Name" required="required" />
    </x-modal>


    <x-modal id="ediModal" action="#" title="Edit Customer Category" bg="success" icon="pencil6">
        @method('PUT')
        <x-input name="code" label="Serial Number" required="required" />
        <x-input name="name" label="Customer Category Name" required="required" />
    </x-modal>

@endsection
