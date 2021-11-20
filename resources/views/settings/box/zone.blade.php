@section('box')

    <x-modal id="myModal" action="{{route('zone.store')}}" title="Add New Zone" icon="grid5">
        <x-input name="name" label="Zone/Area Name" required="required" />
        <x-input name="address" label="Zone Address"/>
    </x-modal>


    <x-modal id="ediModal" action="#" title="Edit Zone" bg="success" icon="pencil6">
        @method('PUT')
        <x-input name="name" label="Zone/Area Name" required="required" />
        <x-input name="address" label="Zone Address"/>
    </x-modal>

@endsection