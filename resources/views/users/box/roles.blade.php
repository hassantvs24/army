@section('box')

    <x-modal id="myModal" action="{{route('roles.store')}}" title="Add New Roles" icon="grid5">
        <x-input name="name" label="Roles Name" required="required" />
    </x-modal>


    <x-modal id="ediModal" action="#" title="Edit Roles Name" bg="success" icon="pencil6">
        @method('PUT')
        <x-input name="name" label="Roles Name" required="required" />
    </x-modal>

    <x-modal id="permissionModal" action="#" title="Assign Permission" bg="warning" size="modal-full" icon="grid5">
        @method('PUT')
        <div class="text-right">
            <button type="button" class="btn btn-link unSelectAll"><b><i class="icon-file-minus2"></i></b> Unmark All</button>
            <button type="button" class="btn btn-link selectAll"><b><i class="icon-file-check2"></i></b> Mark All</button>
        </div>

        <div class="row">
            @foreach($permissions as $permission)
                <div class="col-md-2 mb-20">
                    @foreach($permission as $row)
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" class="val_{{$row->id}}" name="permissions[]" value="{{$row->id}}"> {{Str::ucfirst(Str::slug($row->name, ' '))}}
                            </label>
                        </div>
                    @endforeach
                </div>

            @endforeach
        </div>
    </x-modal>

@endsection