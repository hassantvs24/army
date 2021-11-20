@section('box')

    <x-modal id="myModal" action="{{route('vat-tax.store')}}" title="Add New Vat Tax" icon="grid5">
        <x-input name="name" label="Vat Tax Name/Number" required="required" />
        <x-input name="amount" type="number" label="Amount(%)" rest="step=any min=0" value="0"  required="required" />
    </x-modal>


    <x-modal id="ediModal" action="#" title="Edit Vat Tax Option" bg="success" icon="pencil6">
        @method('PUT')
        <x-input name="name" label="Vat Tax Name/Number" required="required" />
        <x-input name="amount" type="number" label="Amount(%)" rest="step=any min=0" value="0"  required="required" />
    </x-modal>

@endsection