@section('box')

    <x-modal id="myModal" action="{{route('expenses.store')}}" title="Create New Expenses" icon="grid5">
        <x-select class="warehouses" name="warehouses_id" label="Warehouse" required="required" >
            @foreach($warehouse as $row)
                <option value="{{$row->id}}">{{$row->name}}</option>
            @endforeach
        </x-select>
        <x-input class="date_pic" name="created_at" label="Date" required="required" />
        <x-input name="code" label="Serial Number" required="required" value="{{mt_rand()}}" />
        <x-select class="category" name="expense_categories_id" label="Expense Category" required="required" >
            @foreach($category as $row)
                <option value="{{$row->id}}">{{$row->name}}</option>
            @endforeach
        </x-select>
        <x-input type="number" name="amount"  rest="step=any min=1" value="0" label="Amount" required="required" />
        <x-input name="description" label="Descriptions" />
    </x-modal>


    <x-modal id="ediModal" action="#" title="Edit Expenses" bg="success" icon="pencil6">
        @method('PUT')
        <x-select name="warehouses_id" label="Warehouse" required="required" >
            @foreach($warehouse as $row)
                <option value="{{$row->id}}">{{$row->name}}</option>
            @endforeach
        </x-select>
        <x-input class="date_pic" name="created_at" label="Date" required="required" />
        <x-input name="code" label="Serial Number" required="required" value="{{mt_rand()}}" />
        <x-select name="expense_categories_id" label="Expense Category" required="required" >
            @foreach($category as $row)
                <option value="{{$row->id}}">{{$row->name}}</option>
            @endforeach
        </x-select>
        <x-input type="number" name="amount"  rest="step=any min=0" value="0" label="Amount" required="required" />
        <x-input name="description" label="Descriptions" />
    </x-modal>

@endsection
