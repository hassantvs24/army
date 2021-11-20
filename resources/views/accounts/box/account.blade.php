@section('box')

    <x-modal id="myModal" action="{{route('accounts.store')}}" title="Add New Accounts" icon="grid5">
        <x-input name="name" label="Accounts Name" required="required" />
        <x-input name="account_number" label="Account Number"/>
        <x-input name="description" label="Descriptions"/>
    </x-modal>


    <x-modal id="ediModal" action="#" title="Edit Accounts" bg="success" icon="pencil6">
        @method('PUT')
        <x-input name="name" label="Accounts Name" required="required" />
        <x-input name="account_number" label="Account Number"/>
        <x-input name="description" label="Descriptions"/>
    </x-modal>

    <x-modal id="acModal" action="#" title="Make Transaction" icon="wallet">
        @method('PUT')
        <x-input class="date_pic" name="created_at" label="Date" required="required" />

        <x-select class="transaction_type" name="transaction_type" label="Transaction Type" required="required" >
            <option value="IN">Deposit Amount (+)</option>
            <option value="OUT">Withdraw Amount (-)</option>
        </x-select>

        <x-select class="warehouse" name="warehouses_id" label="Select Warehouse" required="required" >
            @foreach($warehouse as $row)
                <option value="{{$row->id}}">{{$row->name}}</option>
            @endforeach
        </x-select>

        <x-select class="payment_method" name="payment_method" label="Payment Method" required="required" >
            <option value="Cash">Cash</option>
            <option value="Cheque">Cheque</option>
            <option value="Bank Transfer">Bank Transfer</option>
            <option value="Other">Other Payment</option>
        </x-select>

        <div class="cheque_number" style="display: none;">
            <x-input name="cheque_number" label="Cheque No" />
        </div>

        <div class="bank_account_no" style="display: none;">
            <x-input name="bank_account_no" label="Bank A/C" />
        </div>

        <div class="transaction_no" style="display: none;">
            <x-input name="transaction_no" label="Other Payment Reference" />
        </div>

        <x-input name="amount" type="number" label="Paid Amount" rest="step=any min=1" value="0" required="required" />

        <x-input name="description" label="Payment Note" />
    </x-modal>

@endsection
