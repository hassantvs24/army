@section('box')

    <x-modal id="myModal" action="{{route('agent.store')}}" title="Add New Agent" icon="grid5">
        <x-select class="warehouse" name="warehouses_id" label="Select Warehouse" required="required" >
            @foreach($warehouse as $row)
                <option value="{{$row->id}}">{{$row->name}}</option>
            @endforeach
        </x-select>
        <x-input name="code" label="Serial Number"  value="{{mt_rand()}}" required="required" />
        <x-input name="name" label="Agent Name" required="required" />
    </x-modal>


    <x-modal id="ediModal" action="#" title="Edit Agent" bg="success" icon="pencil6">
        @method('PUT')
        <x-select name="warehouses_id" label="Select Warehouse" required="required" >
            @foreach($warehouse as $row)
                <option value="{{$row->id}}">{{$row->name}}</option>
            @endforeach
        </x-select>
        <x-input name="code" label="Serial Number" required="required" />
        <x-input name="name" label="Agent Name" required="required" />
    </x-modal>

@endsection
