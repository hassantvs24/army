@extends('layouts.master')
@extends('sales.box.sales')

@section('title')
    Sales
@endsection
@section('content')

    <x-panel name="Sales">
        <form action="{{route('sales.store')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <x-input name="code" label="Serial Number" value="{{mt_rand()}}" required="required" />
                </div>
                <div class="col-md-6">
                    <x-select class="customer" name="customers_id" label="Customer" required="required" >
                        <option value="">Select Customer</option>
{{--                        @foreach($customer as $row)--}}
{{--                            <option value="{{$row->id}}" data-crlimit="{{$row->credit_limit}}" data-balance="{{$row->dueBalance()}}">{{$row->code}} - {{$row->name}} &diams; {{$row->contact}}</option>--}}
{{--                        @endforeach--}}
                    </x-select>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-success btn-labeled btn-labeled-left" data-toggle="modal" data-target="#customerModal"><b><i class="icon-plus2"></i></b> New Customer</button>
                </div>
            </div>


            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="input-group has-success">
                        <span class="input-group-addon" id="basic-addon1">Add Item</span>
                        <select name="products" class="form-control products">
                            <option value="">Select Product</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-20">
                    <table class="table table-striped table-condensed table-hover">
                        <thead>
                        <tr>
                            <th>SKU</th>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Less(%)</th>
                            <th class="text-right">Total</th>
                            <th class="text-right"><i class="icon-bin"></i></th>
                        </tr>
                        </thead>
                        <tbody class="item_list">
                        <!-- Loading Item List -->
                        </tbody>
                        <tfoot class="text-purple">
                        <tr>
                            <th class="text-right" colspan="5">Total:</th>
                            <th class="text-right total_price" data-prices="0">0.00</th>
                            <th class="text-right"><i class="icon-bin"></i></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <x-input class="date_pic" name="created_at" label="Invoice Date" required="required" />
                    <x-input class="date_pic" name="due_date" label="Due Date" required="required" />

                    <x-select class="status" name="status" label="Status" required="required" >
                        <option value="Final">Final</option>
                        <option value="Draft">Draft</option>
                        <option value="Quotation">Quotation</option>
                    </x-select>

                    <x-select class="warehouses" name="warehouses_id" label="Warehouse" required="required" >
                        @foreach($warehouse as $row)
                            <option value="{{$row->id}}">{{$row->name}}</option>
                        @endforeach
                    </x-select>

                    <x-select class="vat_tax" name="vet_texes_id" label="Vat/Tax">
                        <option value="" data-amount="0">Select Vat/Tax Option</option>
                        @foreach($vat_tax as $row)
                            <option value="{{$row->id}}" data-amount="{{$row->amount}}">{{$row->name}} - {{$row->amount}}%</option>
                        @endforeach
                    </x-select>

                    <x-input class="vet_texes_amount" name="vet_texes_amount" type="number" label="Vat Amount" rest="step=any min=0" value="0" required="required" />

                </div>
                <div class="col-md-4">
                    <x-select class="shipment" name="shipments_id" label="Shipment" required="required" >
                        @foreach($shipment as $row)
                            <option value="{{$row->id}}">{{$row->name}}</option>
                        @endforeach
                    </x-select>

                    <x-input class="additional_charges" name="additional_charges" type="number" label="Other Cost" rest="step=any min=0" value="0" required="required" />

                    <x-select class="discount" name="discounts_id" label="Discount">
                        <option value="" data-amount="0" data-distype="Fixed">Select Discount Option</option>
                        @foreach($discount as $row)
                            <option value="{{$row->id}}" data-amount="{{$row->amount}}" data-distype="{{$row->getRawOriginal('discount_type')}}">{{$row->name}} - {{$row->amount}}{{$row->discount_type}}</option>
                        @endforeach
                    </x-select>

                    <x-input class="discount_amount" name="discount_amount" type="number" label="Discount Amount" rest="step=any min=0" value="0" required="required" />

                    <x-input name="invoice_description" label="Notes" />

                </div>
                <div class="col-md-4">
                    <table class="table table-striped table-bordered table-condensed table-hover mb-20">
                        <tr>
                            <th>Total Discount</th>
                            <td class="discount_show">0.00</td>
                        </tr>
                        <tr>
                            <th>Total Vat</th>
                            <td class="vat_show">0.00</td>
                        </tr>
                        <tr>
                            <th>Other Cost</th>
                            <td class="labour_show">0.00</td>
                        </tr>
                        <tr class="info">
                            <th>Total</th>
                            <td class="total_show" data-total="0">0.00</td>
                        </tr>
                        <tr class="success">
                            <input type="hidden" class="totalPaid" value="0" />
                            <th>Paid</th>
                            <td class="paid_show">0.00</td>
                        </tr>
                        <tr class="danger">
                            <th>Due</th>
                            <td class="due_show" data-due="0">0.00</td>
                        </tr>
                    </table>
                    <p id="credit_limit" class="text-warning text-right" style="display: none;"><i class="icon-warning22"></i> <b>Customer Credit Limit is over!!</b></p>
                </div>

            </div>

            <div class="row">
                <div class="col-md-4 col-md-offset-4 text-right">
                    <button type="button" class="btn btn-warning btn-labeled btn-labeled-left" data-toggle="modal" data-target="#myModal"><b><i class="icon-cash4"></i></b> Make a payment?</button>
                </div>
                <div class="col-md-4 text-right">
                    <button id="submitBtn" type="submit" class="btn btn-primary btn-labeled btn-labeled-left"><b><i class="icon-checkmark4"></i></b> Submit</button>
                </div>

            </div>

            <div class="row">
                <div class="col-md-5"><hr /></div>
                <div class="col-md-2 text-center">Payment List</div>
                <div class="col-md-5"><hr /></div>
            </div>

            <div class="row">
                <div class="col-md-12">

                    <table class="table table-striped table-condensed table-hover">
                        <thead>
                        <tr>
                            <th>Account</th>
                            <th>Pay Method</th>
                            <th>Cheque</th>
                            <th>Bank</th>
                            <th>Reference</th>
                            <th>Note</th>
                            <th class="text-right">Amount</th>
                            <th class="text-right"><i class="icon-bin"></i></th>
                        </tr>
                        </thead>
                        <tbody class="payment_list">
                        <!-- Loading Payment List -->
                        </tbody>
                        <tfoot class="text-primary">
                        <tr>
                            <th class="text-right" colspan="6">Total:</th>
                            <th class="text-right total_pay_amount" data-amount="0">0.00</th>
                            <th class="text-right"><i class="icon-bin"></i></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <input type="hidden" class="all_pay_total" name="total_all_pay" value="0" />
            <div class="pay_input_list">
                <!-- this is payment hidden input list -->
            </div>
        </form>
    </x-panel>

@endsection

@section('script')
    <script type="text/javascript">

        if(performance.navigation.type === 2) {//Refresh back btn history
            location.reload();
        }

        var all_items = [];
        var all_payment = [];

        $(function () {

            handle_submit_btn();//Disable Enable Submit Button

            $('.products').change(function () {
                var products = $(this).val();

                if(products != ''){
                    var productArr = products.split(' -x- ');
                    const single_item = all_items.filter(all_item => all_item.id == productArr[0]);
                    if(single_item.length === 0){
                        all_items.unshift({
                            id: productArr[0],
                            sku: productArr[1],
                            name: productArr[2],
                            price: productArr[3],
                            discount: 0,
                            discount_type: 'Percentage',
                            qty: 1,
                        });
                    }

                    render_item();
                }
            });

            $('#myModal [type=submit]').click(function () {
                var account = $('#myModal [name=account_books_id]').val();
                var amount = $('#myModal [name=paid]').val();
                var payment_method = $('#myModal [name=payment_method]').val();
                var cheque_number = $('#myModal [name=cheque_number]').val();
                var bank_account_no = $('#myModal [name=bank_account_no]').val();
                var transaction_no = $('#myModal [name=transaction_no]').val();
                var description = $('#myModal [name=description]').val();
                var account_name = $('#myModal [name=account_books_id]').find('option:selected').data('name');

                var due = Number($('.due_show').attr('data-due'));

                if(amount > 0 && amount <= due){
                    all_payment.push({
                        accounts: account,
                        name: account_name,
                        payment: amount,
                        methods: payment_method,
                        cheque: cheque_number,
                        bank: bank_account_no,
                        transaction: transaction_no,
                        description: description
                    });
                    $('#myModal').modal('hide');
                    $('#myModal [name=paid]').val(0);
                    $('#myModal [name=payment_method]').val('Cash');
                    $('#myModal [name=cheque_number]').val('');
                    $('#myModal [name=bank_account_no]').val('');
                    $('#myModal [name=transaction_no]').val('');
                    $('#myModal [name=description]').val('');

                    $('.cheque_number').hide();
                    $('.bank_account_no').hide();
                    $('.transaction_no').hide();
                    render_payment();
                }else{
                    alert('Please input valid amount.');
                }
            });

            $('.discount, .vat_tax').change(function () {
                handle_vat_discount();
            });

            $('.payment_method').change(function () {
                var methods = $(this).val();

                switch(methods) {
                    case "Cheque":
                        $('.cheque_number').show();
                        $('.bank_account_no').hide();
                        $('.transaction_no').hide();
                        break;
                    case "Bank Transfer":
                        $('.cheque_number').hide();
                        $('.bank_account_no').show();
                        $('.transaction_no').hide();
                        break;
                    case "Other":
                        $('.cheque_number').hide();
                        $('.bank_account_no').hide();
                        $('.transaction_no').show();
                        break;
                    default:
                        $('.cheque_number').hide();
                        $('.bank_account_no').hide();
                        $('.transaction_no').hide();
                }

            });

            $('.additional_charges, .customer, .discount, .vat_tax, .vet_texes_amount, .discount_amount').on('change focusout', function () {
                final_change();
            });


            $('.paid').dblclick(function () {
                var total = Number($('.total_show').attr('data-total'));
                var pay_amount = Number($('.all_pay_total').val());
                var grand_total = total - pay_amount;
                if(grand_total > 0)
                    $(this).val(grand_total);
            });


            $('.warehouses').val("{{auth()->user()->warehouses_id}}").select2();
            $('.accounts').val("{{auth()->user()->account_books_id}}").select2();

            $('.customer').select2({
                ajax: {
                    url: "{{route('customer.api')}}",
                    delay: 250,
                    data: function (params) {
                        // Query parameters will be ?search=[term]&type=public
                        return {search: params.term};
                    }
                }
            });


            $('.products').select2({
                ajax: {
                    url: "{{route('product.api')}}",
                    delay: 250,
                    data: function (params) {
                        // Query parameters will be ?search=[term]&type=public
                        return {search: params.term, type: 'sales' };
                    }
                }
            });

            $('.category, .zilla, .agent, .warehouse, .status, .vat_tax, .discount, .shipment, .payment_method').select2();

            $('.date_pic').daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });
        });

        /**
         * Render Item Table
         */
        function render_item() {
            var tbl_item = '';
            var total_price = 0;
            $.each(all_items, function( index, value ) {
                var discounts_rate = Number(value.price * value.discount / 100);
                tbl_item += `<tr>
                        <td>${value.sku}</td>
                        <td><input name="name[${value.id}]" value="${value.name}" class="form-control nameChange" data-id="${value.id}" type="text" placeholder="Product Name" /></td>
                        <td><input name="qty[${value.id}]" value="${value.qty}" class="form-control qtyItem" data-id="${value.id}" type="number" step="any" min="0.01" placeholder="Quantity" /></td>
                        <td><input name="price[${value.id}]" value="${value.price}" class="form-control priceItem" data-id="${value.id}" type="number" step="any" min="0.01" placeholder="Price" /></td>
                        <td><input name="discounts[${value.id}]" value="${value.discount}" class="form-control discountItem"  data-id="${value.id}" type="number" step="any" min="0" max="100" placeholder="Discount" /></td>
                        <td class="text-right">${Number((value.price - discounts_rate) * value.qty).toFixed(2)}</td>
                        <td class="text-right"><button type="button" class="btn btn-danger btn-xs delete_item" value="${value.id}"><i class="icon-bin"></i></button></td>
                        <input type="hidden" name="discount_type[${value.id}]" value="Percentage" />
                    </tr>`;

                total_price += Number((value.price - discounts_rate) * value.qty);
            });
            $('.item_list').html(tbl_item);
            $('.total_price').html(total_price.toFixed(2));
            $('.total_price').attr('data-prices', total_price);
            //console.log(total_price);
            del_item();
            update_item();
            final_change();
            handle_submit_btn();//Disable Enable Submit Button
        }
        /**
         * /Render Item Table
         */

        /**
         * Render Payment Table
         */
        function render_payment() {
            var tbl_pay = '';
            var input_add = '';
            var total_amount = 0;
            $.each(all_payment, function( index, value ) {
                tbl_pay += `<tr>
                        <td>${value.name}</td>
                        <td>${value.methods}</td>
                        <td>${value.cheque}</td>
                        <td>${value.bank}</td>
                        <td>${value.transaction}</td>
                        <td>${value.description}</td>
                        <td class="text-right">${Number(value.payment).toFixed(2)}</td>
                        <td class="text-right"><button type="button" class="btn btn-danger btn-xs delete_payment" value="${index}"><i class="icon-bin"></i></button></td>
                    </tr>`;

                input_add += `<input type="hidden" name="amount[]" value="${value.payment}" />
                                <input type="hidden" name="payment_method[]" value="${value.methods}" />
                                <input type="hidden" name="cheque_number[]" value="${value.cheque}" />
                                <input type="hidden" name="bank_account_no[]" value="${value.bank}" />
                                <input type="hidden" name="transaction_no[]" value="${value.transaction}" />
                                <input type="hidden" name="description[]" value="${value.description}" />
                                <input type="hidden" name="account_books_id[]" value="${value.accounts}" />`;

                total_amount += Number(value.payment);
            });

            $('.payment_list').html(tbl_pay);
            $('.total_pay_amount').html(total_amount.toFixed(2));
            $('.pay_input_list').html(input_add);
            $('.total_pay_amount').attr('data-amount',total_amount);
            $('.all_pay_total').val(total_amount);

            del_payment();
            final_change();
        }
        /**
         * /Render Payment Table
         */

        /**
         * Delete Item
         */
        function del_item(){
            $('.delete_item').click(function () {
                var id = $(this).val();
                all_items = all_items.filter(all_item => all_item.id != id);
                render_item();
            });
        }
        /**
         * /Delete Item
         */

        /**
         * Delete payment
         */
        function del_payment() {
            $('.delete_payment').click(function () {
                var id = $(this).val();
                all_payment = all_payment.filter((all_pay, index) => index != id);
                render_payment();
            });
        }
        /**
         * /Delete payment
         */

        /**
         * Handle Item Information
         */
        function update_item(){
            $('.qtyItem').change(function () {
                var id = $(this).data('id');
                var cu_val = $(this).val();
                var objIndex = all_items.findIndex((obj => obj.id == id));
                all_items[objIndex].qty = cu_val;
                render_item();
            });

            $('.priceItem').change(function () {
                var id = $(this).data('id');
                var cu_val = $(this).val();
                var objIndex = all_items.findIndex((obj => obj.id == id));
                all_items[objIndex].price = cu_val;
                render_item();
            });

            $('.discountItem').change(function () {
                var id = $(this).data('id');
                var cu_val = $(this).val();
                var objIndex = all_items.findIndex((obj => obj.id == id));
                all_items[objIndex].discount = cu_val;
                render_item();
            });

            $('.nameChange').change(function () {
                var id = $(this).data('id');
                var cu_val = $(this).val();
                var objIndex = all_items.findIndex((obj => obj.id == id));
                all_items[objIndex].name = cu_val;
            });


        }
        /**
         * /Handle Item Information
         */


        /**
         * Handle Vat Tax & Discount Input
         */
        function handle_vat_discount() {
            var total_price = Number($('.total_price').attr('data-prices'));
            var discount = Number($('.discount').find('option:selected').data('amount'));
            var vat_tax = Number($('.vat_tax').find('option:selected').data('amount'));
            var distype = $('.discount').find('option:selected').data('distype');
            var show_discount = 0;
            if(distype == 'Fixed'){
                show_discount = discount;
            }else{
                show_discount = Number((total_price * discount)/100);
            }
            var show_vat = Number((total_price * vat_tax)/100);

            $('.vet_texes_amount').val(show_vat);
            $('.discount_amount').val(show_discount);
        }
        /**
         * /Handle Vat Tax & Discount Input
         */


        /**
         * Form Input Change
         */
        function final_change(){
            var additional_charges = Number($('.additional_charges').val());
            var paid = Number($('.all_pay_total').val());
            var total_price = Number($('.total_price').attr('data-prices'));
            var show_vat = $('.vet_texes_amount').val();
            var show_discount = $('.discount_amount').val();

            var total_show = Number(total_price) + Number(show_vat) + Number(additional_charges) - Number(show_discount);

            var due_show = Number(total_show - paid);

            $('.discount_show').html(parseFloat(show_discount).toFixed(2));
            $('.vat_show').html(parseFloat(show_vat).toFixed(2));
            $('.labour_show').html(parseFloat(additional_charges).toFixed(2));
            $('.total_show').html(total_show.toFixed(2));
            $('.paid_show').html(parseFloat(paid).toFixed(2));
            $('.due_show').html(due_show.toFixed(2));
            $('.due_show').attr('data-due', due_show);
            $('.total_show').attr('data-total', total_show);

            handle_submit_btn();//Disable Enable Submit Button
            cr_limit();//Show Credit Limit of customer
        }
        /**
         * /Form Input Change
         */

        /**
         * Disable submit btn when 0 item and invalid payment
         */
        function handle_submit_btn() {
            var due = Number($('.due_show').attr('data-due'));

            if(all_items.length > 0 && due >= 0){
                $('#submitBtn').prop('disabled', false);
            }else{
                $('#submitBtn').prop('disabled', true);
            }
        }
        /**
         * /Disable submit btn when 0 item and invalid payment
         */

        /**
         * Customer Credit Limit
         */
        function cr_limit() {
            var id = $('.customer').val();

            var balance = 0;
            var crlimit = 0;

            $.getJSON( "{{route('customer_bl.api')}}?id="+id, function( data ){
                 balance = data[1];
                 crlimit = data[0];
            });

            var due = Number($('.due_show').attr('data-due'));
            var crbalance = balance - due;
            var cr_abs = Math.abs(crbalance);

            if(crlimit == 0){
                $('#credit_limit').hide();
                //$('#submitBtn').prop('disabled', false);
            }else if (crbalance >= 0){
                $('#credit_limit').hide();
                //$('#submitBtn').prop('disabled', false);
            }else if (cr_abs <= crlimit){
                $('#credit_limit').hide();
                //$('#submitBtn').prop('disabled', false);
            }else{
                $('#credit_limit').show();
                //$('#submitBtn').prop('disabled', true);
            }
        }
        /**
         * Customer Credit Limit
         */


    </script>
@endsection