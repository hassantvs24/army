@section('box')

    <x-modal id="myModal" action="{{route('sub-district.store')}}" title="Add New Sub District" icon="grid5">
        <x-select class="district" name="zillas_id" label="District" required="required" >
            @foreach($zilla as $row)
                <option value="{{$row->id}}">{{$row->name}}</option>
            @endforeach
        </x-select>
        <x-input name="name" label="Sub District Name" required="required" />
    </x-modal>


    <x-modal id="ediModal" action="#" title="Edit Sub District" bg="success" icon="pencil6">
        @method('PUT')
        <x-select name="zillas_id" label="District" required="required" >
            @foreach($zilla as $row)
                <option value="{{$row->id}}">{{$row->name}}</option>
            @endforeach
        </x-select>
        <x-input name="name" label="Sub District Name" required="required" />
    </x-modal>

@endsection
