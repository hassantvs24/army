@section('box')

    <x-modal id="myModal" action="{{route('customer.store')}}" size="modal-full" title="Add New Customer" icon="grid5">
        <div class="row">
            <div class="col-md-6">
                <x-select class="warehouse" name="warehouses_id" label="Select Warehouse" required="required" >
                    @foreach($warehouse as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
                </x-select>

                <x-select class="category" name="customer_categories_id" label="Customer Category" required="required" >
                    @foreach($category as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
                </x-select>

                <x-select class="upa_zaill" name="upa_zillas_id" label="Sub District" required="required" >
                    @foreach($upa_zilla as $row)
                        <option value="{{$row->id}}">{{$row->name}} - {{$row->zilla['name']}}</option>
                    @endforeach
                </x-select>

                <x-select class="agent" name="agent_id" label="Assign Person" required="required" >
                    @foreach($agent as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
                </x-select>

                <x-input name="code" label="Serial Number" required="required" value="{{mt_rand()}}" />
                <x-input name="name" label="Customer Name" required="required" />
                <x-input name="contact" label="Contact Number" required="required"  />
                <x-input type="email" name="email" label="Email Address" />
            </div>

            <div class="col-md-6">
                <x-input name="contact_person" label="Contact person"/>
                <x-input name="phone" label="Phone Number" />
                <x-input name="alternate_contact" label="Alternate Contact" />
                <x-input name="address" label="Address" />
                <x-input type="number" name="credit_limit"  rest="step=any min=0" value="0" label="Credit Limit" required="required" />
                <x-input type="number" name="sells_target"  rest="step=any min=0" value="0" label="Sells Target" required="required" />
                <x-input type="number" name="balance"  rest="step=any" value="0" label="Opening Balance" required="required" />
                <x-input name="description" label="Additional Note" />
            </div>
        </div>


    </x-modal>


    <x-modal id="ediModal" action="#" title="Edit Customer" size="modal-full" bg="success" icon="pencil6">
        @method('PUT')
        <div class="col-md-6">
            <x-select name="warehouses_id" label="Select Warehouse" required="required" >
                @foreach($warehouse as $row)
                    <option value="{{$row->id}}">{{$row->name}}</option>
                @endforeach
            </x-select>

            <x-select name="customer_categories_id" label="Customer Category" required="required" >
                @foreach($category as $row)
                    <option value="{{$row->id}}">{{$row->name}}</option>
                @endforeach
            </x-select>

            <x-select name="zillas_id" label="District" required="required" >
                @foreach($zilla as $row)
                    <option value="{{$row->id}}">{{$row->name}}</option>
                @endforeach
            </x-select>

            <x-select name="agent_id" label="Assign Person" required="required" >
                @foreach($agent as $row)
                    <option value="{{$row->id}}">{{$row->name}}</option>
                @endforeach
            </x-select>

            <x-input name="code" label="Serial Number" required="required" />
            <x-input name="name" label="Customer Name" required="required" />
            <x-input name="contact" label="Contact Number" required="required"  />
            <x-input type="email" name="email" label="Email Address" />


        </div>

        <div class="col-md-6">
            <x-input name="contact_person" label="Contact person"/>
            <x-input name="phone" label="Phone Number" />
            <x-input name="alternate_contact" label="Alternate Contact" />
            <x-input name="address" label="Address" />
            <x-input type="number" name="credit_limit"  rest="step=any min=0" value="0" label="Credit Limit" required="required" />
            <x-input type="number" name="sells_target"  rest="step=any min=0" value="0" label="Sells Target" required="required" />
            <x-input type="number" name="balance"  rest="step=any" value="0" label="Opening Balance" required="required" />
            <x-input name="description" label="Additional Note" />
        </div>
    </x-modal>


    <x-modal id="payModal" action="#" title="Make a payment" icon="grid5">
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

            <x-input name="amount" type="number" label="Paid Amount" rest="step=any min=0" value="0" required="required" />

            <x-input name="description" label="Payment Note" />

            <!--<p class="m-0 text-right">
                <span class="help-block">**Double Click on "Paid Amount" Input box for automatic payment.</span>
            </p>-->
    </x-modal>

@endsection
