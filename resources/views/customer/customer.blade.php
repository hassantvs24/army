@extends('layouts.master')
@extends('customer.box.customer')

@section('title')
    Customer
@endsection

@section('content')


    <x-site name="Customer List">
        <x-slot name="header">
            @can('Customer Create')
                <button id="headerBtn" type="button" class="btn btn-primary heading-btn btn-labeled btn-labeled-left" data-toggle="modal" data-target="#myModal"><b><i class="icon-add-to-list"></i></b> Add New Customer</button>
            @endcan
        </x-slot>

        <div class="mb-15 text-center">{{ $table->links() }}</div>

        <table class="table table-striped table-condensed table-hover datatable-basic">
            <thead>
            <tr>
                <th class="p-th">S/N</th>
                <th class="p-th">Name</th>
                <th class="p-th">Contact</th>
                <th class="p-th">Upazilla</th>
                <th class="p-th">Category</th>
                <th class="p-th">Agent</th>
                <th title="Credit Limit" class="p-th">Cr.Limit</th>
                <th class="p-th" title="Monthly Target">Target</th>
                <th class="p-th">Balance</th>
                <th class="text-right"><i class="icon-more"></i></th>
            </tr>
            </thead>
            <tbody>
            @foreach($table as $row)
                <tr>
                    <td class="p-td">{{$row->code}}</td>
                    <td class="p-td">{{$row->name}}</td>
                    <td class="p-td">{{$row->contact}}</td>
                    <td class="p-td">{{$row->upaZilla['name']}}</td>
                    <td class="p-td">{{$row->customerCategory['name']}}</td>
                    <td class="p-td">{{$row->agent['name']}}</td>
                    <td class="p-td">{{money_c($row->credit_limit)}}</td>
                    <td class="p-td">{{money_c($row->sells_target)}}</td>
                    <td class="p-td">{{money_c($row->dueBalance())}}</td>
                    <td class="text-right p-td">
                        <x-actions>
                            @can('Customer Edit')
                                <li><a href="#{{route('customer.update', ['list' => $row->id])}}"
                                   data-code="{{$row->code}}"
                                   data-name="{{$row->name}}"
                                   data-contact="{{$row->contact}}"
                                   data-person="{{$row->contact_person}}"
                                   data-email="{{$row->email}}"
                                   data-address="{{$row->address}}"
                                   data-phone="{{$row->phone}}"
                                   data-contacttwo="{{$row->alternate_contact}}"
                                   data-upazillas="{{$row->upa_zillas_id}}"
                                   data-agent="{{$row->agent_id}}"
                                   data-category="{{$row->customer_categories_id}}"
                                   data-warehouse="{{$row->warehouses_id}}"
                                   data-crlimit="{{$row->credit_limit}}"
                                   data-starget="{{$row->sells_target}}"
                                   data-balance="{{$row->balance}}"
                                   data-description="{{$row->description}}"
                                   class="ediItem" data-toggle="modal" data-target="#ediModal"><i class="icon-pencil6 text-success"></i> Edit</a></li>
                            @endcan
                            @can('Customer Transaction')
                                <li><a href="{{route('customer.show', ['list' => $row->id])}}"><i class="icon-shuffle text-primary"></i> Customer Transaction</a></li>
                            @endcan
                            @can('Customer Payment')
                                <li><a href="{{route('customer.payment', ['id' => $row->id])}}" class="payment" data-balance="{{$row->dueBalance()}}" data-toggle="modal" data-target="#payModal"><i class="icon-wallet text-purple"></i> Payment</a></li>
                            @endcan
                            @can('Customer Delete')
                                <li><a href="{{route('customer.destroy', ['list' => $row->id])}}" class="delItem"><i class="icon-bin text-danger"></i> Delete</a></li>
                            @endcan
                        </x-actions>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="mt-5 mb-15 text-center">{{ $table->links() }}</div>
    </x-site>


@endsection

@section('script')
    <script type="text/javascript">
        var balance = 0;
        $(function () {

            $('.warehouse').val("{{auth()->user()->warehouses_id}}").select2();
            $('.accounts').val("{{auth()->user()->account_books_id}}").select2();

            $('.category, .upa_zaill, .agent, .payment_method').select2();

            $('.ediItem').click(function (e) {
                e.preventDefault();
                var url = $(this).attr('href').substr(1);
                var name = $(this).data('name');
                var code = $(this).data('code');
                var email = $(this).data('email');
                var address = $(this).data('address');
                var phone = $(this).data('phone');
                var alternate_contact = $(this).data('contacttwo');
                var upa_zillas_id = $(this).data('upazillas');
                var agent_id = $(this).data('agent');
                var contact = $(this).data('contact');
                var warehouses_id = $(this).data('warehouse');
                var credit_limit = $(this).data('crlimit');
                var sells_target = $(this).data('starget');
                var balance = $(this).data('balance');
                var customer_categories_id = $(this).data('category');
                var description = $(this).data('description');
                var contact_person = $(this).data('person');

                $('#ediModal form').attr('action', url);
                $('#ediModal [name=name]').val(name);
                $('#ediModal [name=code]').val(code);
                $('#ediModal [name=email]').val(email);
                $('#ediModal [name=address]').val(address);
                $('#ediModal [name=phone]').val(phone);
                $('#ediModal [name=alternate_contact]').val(alternate_contact);
                $('#ediModal [name=contact]').val(contact);
                $('#ediModal [name=credit_limit]').val(credit_limit);
                $('#ediModal [name=sells_target]').val(sells_target);
                $('#ediModal [name=balance]').val(balance);
                $('#ediModal [name=description]').val(description);
                $('#ediModal [name=contact_person]').val(contact_person);

                $('#ediModal [name=agent_id]').val(agent_id).select2();
                $('#ediModal [name=upa_zillas_id]').val(upa_zillas_id).select2();
                $('#ediModal [name=warehouses_id]').val(warehouses_id).select2();
                $('#ediModal [name=customer_categories_id]').val(customer_categories_id).select2();

            });

            $('.payment').click(function (e) {
                e.preventDefault();

                $('#payModal [name=amount]').val(0);

                $('.cheque_number').hide();
                $('.bank_account_no').hide();
                $('.transaction_no').hide();
                $('.customer_balance').hide();

                var url = $(this).attr('href');
                balance = Number($(this).data('balance'));

                $('#payModal form').attr('action', url);
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


            $('.date_pic').daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });

            $('.datatable-basic').DataTable({
                columnDefs: [
                    { orderable: false, "targets": [9] }
                ]
            });
        });


    </script>
@endsection