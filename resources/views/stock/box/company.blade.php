@section('box')

    <x-modal id="myModal" action="{{route('company.store')}}" title="Add New Company" icon="grid5">
        <x-input name="name" label="Company Name" required="required" />
        <x-input name="description" label="Company Description"/>
    </x-modal>


    <x-modal id="ediModal" action="#" title="Edit Company" bg="success" icon="pencil6">
        @method('PUT')
        <x-input name="name" label="Company Name" required="required" />
        <x-input name="description" label="Company Description"/>
    </x-modal>

@endsection