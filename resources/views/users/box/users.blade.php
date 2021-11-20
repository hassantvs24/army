@section('box')

    <x-modal id="myModal" action="{{route('users.store')}}" title="Add New Users" icon="grid5">
        <input type="hidden" name="business_id" value="{{Auth::user()->business_id}}"/>
        <x-select class="warehouses" name="warehouses_id" label="Warehouse" required="required" >
            @foreach($warehouse as $row)
                <option value="{{$row->id}}">{{$row->name}}</option>
            @endforeach
        </x-select>
        <x-select class="accounts" name="account_books_id" label="Account Book" required="required" >
            @foreach($ac_book as $row)
                <option value="{{$row->id}}">{{$row->name}}({{$row->account_number}})</option>
            @endforeach
        </x-select>

        <x-select class="roles" name="role_id" label="User Role" required="required" >
            @foreach($roles as $row)
                <option value="{{$row->id}}">{{$row->name}}</option>
            @endforeach
        </x-select>

        <x-input name="name" label="User Name" required="required" rest="autocomplete=off" />
        <x-input name="email" type="email" label="User Email" required="required" rest="autocomplete=off" />
        <x-input name="password" type="password" label="Password" required="required" rest="autocomplete=off" />
        <x-input name="password_confirmation" type="password" label="Password Confirmation" required="required" />
    </x-modal>


    <x-modal id="ediModal" action="#" title="Edit Users" bg="success" icon="pencil6">
        @method('PUT')
        <input type="hidden" name="business_id" value="{{Auth::user()->business_id}}"/>
        <x-select name="warehouses_id" label="Warehouse" required="required" >
            @foreach($warehouse as $row)
                <option value="{{$row->id}}">{{$row->name}}</option>
            @endforeach
        </x-select>
        <x-select name="account_books_id" label="Account Book" required="required" >
            @foreach($ac_book as $row)
                <option value="{{$row->id}}">{{$row->name}}({{$row->account_number}})</option>
            @endforeach
        </x-select>

        <x-select name="role_id" label="User Role" required="required" >
            @foreach($roles as $row)
                <option value="{{$row->id}}">{{$row->name}}</option>
            @endforeach
        </x-select>

        <x-input name="name" label="User Name" required="required" rest="autocomplete=off" />
        <x-input name="email" type="email" label="User Email" required="required" rest="autocomplete=off" />
        <x-input name="password" type="password" label="Password" required="required" rest="autocomplete=off" />
        <x-input name="password_confirmation" type="password" label="Password Confirmation" required="required" />
    </x-modal>

@endsection
