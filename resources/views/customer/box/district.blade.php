@section('box')

    <x-modal id="myModal" action="{{route('district.store')}}" title="Add New District" icon="grid5">
        <input type="hidden" name="divisions_id" value="5" />
        <x-input name="name" label="District Name" required="required" />
    </x-modal>


    <x-modal id="ediModal" action="#" title="Edit District" bg="success" icon="pencil6">
        @method('PUT')
        <input type="hidden" name="divisions_id" value="5" />
        <x-input name="name" label="District Name" required="required" />
    </x-modal>

@endsection
