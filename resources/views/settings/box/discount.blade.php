@section('box')

    <x-modal id="myModal" action="{{route('discount.store')}}" title="Add New Discount" icon="grid5">
        <x-input name="name" label="Discount Option Name" required="required" />
        <x-select class="select2" name="discount_type" label="Discount Type" required="required" >
            <option value="Fixed">Fixed</option>
            <option value="Percentage">Percentage</option>
        </x-select>
        <x-input name="amount" type="number" label="Amount" rest="step=any min=0" value="0"  required="required" />
    </x-modal>


    <x-modal id="ediModal" action="#" title="Edit Discount Option" bg="success" icon="pencil6">
        @method('PUT')
        <x-input name="name" label="Discount Option Name" required="required" />
        <x-select class="ediSelect2" name="discount_type" label="Discount Type" required="required" >
            <option value="Fixed">Fixed</option>
            <option value="Percentage">Percentage</option>
        </x-select>
        <x-input name="amount" type="number" label="Amount" rest="step=any min=0" value="0"  required="required" />
    </x-modal>

@endsection