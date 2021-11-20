@section('box')

    <x-modal id="myModal" action="{{route('accounts.payment', ['id' => $table->id])}}" title="Make Transaction" icon="wallet">
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


    <x-modal id="ediModal" action="#" title="Edit Transaction" bg="success" icon="wallet">
        @method('PUT')

        <input type="hidden" name="account_books_id" />
        <input type="hidden" name="transaction_hub" />
        <input type="hidden" name="transaction_point" />

        <x-input class="date_pic" name="created_at" label="Date" required="required" />

        <x-select name="transaction_type" label="Transaction Type" required="required" >
            <option value="IN">Deposit Amount (+)</option>
            <option value="OUT">Withdraw Amount (-)</option>
        </x-select>

        <x-select name="warehouses_id" label="Select Warehouse" required="required" >
            @foreach($warehouse as $row)
                <option value="{{$row->id}}">{{$row->name}}</option>
            @endforeach
        </x-select>

        <x-select name="payment_method" label="Payment Method" required="required" >
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

        <p class="m-0 text-right">
            <span class="help-block">**Transaction Type only applicable for Account Book Section.</span>
        </p>
    </x-modal>

@endsection
