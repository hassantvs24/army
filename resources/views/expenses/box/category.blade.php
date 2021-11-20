@section('box')

    <x-modal id="myModal" action="{{route('expense-category.store')}}" title="Add New Expense Category" icon="grid5">
        <x-input name="code" label="Serial Number" required="required" />
        <x-input name="name" label="Expense Category Name" required="required" />
    </x-modal>


    <x-modal id="ediModal" action="#" title="Edit Expense Category" bg="success" icon="pencil6">
        @method('PUT')
        <x-input name="code" label="Serial Number" required="required" />
        <x-input name="name" label="Expense Category Name" required="required" />
    </x-modal>

@endsection
