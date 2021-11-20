@section('box')
    <x-modal id="myModal" action="{{route('customer.payment', ['id' => $customer->id])}}" title="Make a payment" icon="grid5">
        @method('PUT')
        <x-input class="date_pic" name="created_at" label="Date" required="required" />
        <x-select class="warehouse" name="warehouses_id" label="Select Warehouse" required="required" >
            @foreach($warehouse as $row)
                <option value="{{$row->id}}">{{$row->name}}</option>
            @endforeach
        </x-select>

        <x-select class="accounts" name="account_books_id" label="Account Book" required="required" >
            @foreach($ac_book as $row)
                <option value="{{$row->id}}" data-name="{{$row->name}}">{{$row->name}}({{$row->account_number}})</option>
            @endforeach
        </x-select>

        <x-select class="payment_method" name="payment_method" label="Payment Method" required="required" >
            <option value="Cash">Cash</option>
            <option value="Cheque">Cheque</option>
            <option value="Bank Transfer">Bank Transfer</option>
            <option value="Other">Other Payment</option>
            <!--<option value="Customer Account">Customer Account</option>-->
        </x-select>

        <p class="customer_balance text-right text-danger" style="display: none;"></p>

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

        <!--<p class="m-0 text-right">
            <span class="help-block">**Double Click on "Paid Amount" Input box for automatic payment.</span>
        </p>-->
    </x-modal>

    <x-modal id="ediModal" action="#" title="Edit Transaction" bg="success" icon="wallet">
        @method('PUT')

        <input type="hidden" name="transaction_hub" />
        <input type="hidden" name="transaction_point" />
        <input type="hidden" name="transaction_type" />

        <x-input class="date_pic" name="created_at" label="Date" required="required" />

        <x-select name="warehouses_id" label="Select Warehouse" required="required" >
            @foreach($warehouse as $row)
                <option value="{{$row->id}}">{{$row->name}}</option>
            @endforeach
        </x-select>

        <x-select class="accounts" name="account_books_id" label="Account Book" required="required" >
            @foreach($ac_book as $row)
                <option value="{{$row->id}}" data-name="{{$row->name}}">{{$row->name}}({{$row->account_number}})</option>
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

    </x-modal>

@endsection
