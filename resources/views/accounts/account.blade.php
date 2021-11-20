@extends('layouts.master')
@extends('accounts.box.account')

@section('title')
    Accounts
@endsection

@section('content')


    <x-site name="Accounts" body="Add New Account">

        <x-slot name="header">
            @can('Accounts Create')
                <button id="headerBtn" type="button" class="btn btn-primary heading-btn btn-labeled btn-labeled-left" data-toggle="modal" data-target="#myModal"><b><i class="icon-add-to-list"></i></b> Add New Account</button>
            @endcan
        </x-slot>

        <table class="table table-striped table-condensed table-hover datatable-basic">
            <thead>
            <tr>
                <th class="p-th">Name</th>
                <th class="p-th">Account Number</th>
                <th class="p-th">Descriptions</th>
                <th class="p-th">IN</th>
                <th class="p-th">OUT</th>
                <th class="p-th">Balance</th>
                <th class="text-right"><i class="icon-more"></i></th>
            </tr>
            </thead>
            <tbody>
            @foreach($table as $row)
                <tr>
                    <td class="p-td">{{$row->name}}</td>
                    <td class="p-td">{{$row->account_number}}</td>
                    <td class="p-td">{{$row->description}}</td>
                    <td class="p-td">{{money_c($row->in())}}</td>
                    <td class="p-td">{{money_c($row->out())}}</td>
                    <td class="p-td">{{money_c($row->acBalance())}}</td>
                    <td class="text-right p-td">
                        <x-actions>
                            @can('Accounts Edit')
                                <li><a href="{{route('accounts.update', ['list' => $row->id])}}"
                                   data-name="{{$row->name}}"
                                   data-acnumber="{{$row->account_number}}"
                                   data-description="{{$row->description}}"
                                   class="ediItem" data-toggle="modal" data-target="#ediModal"><i class="icon-pencil6 text-success"></i> Edit</a></li>
                            @endcan
                            @can('Accounts Transaction')
                                <li><a href="{{route('accounts.show', ['list' => $row->id])}}"><i class="icon-shuffle text-primary"></i> Account Transaction</a></li>
                            @endcan
                            @can('Transaction Create')
                                <li><a href="{{route('accounts.payment', ['id' => $row->id])}}" class="payments" data-toggle="modal" data-target="#acModal"><i class="icon-wallet text-purple"></i> Make Transaction</a></li>
                            @endcan
                            @can('Accounts Delete')
                                <li><a href="{{route('accounts.destroy', ['list' => $row->id])}}" class="delItem"><i class="icon-bin text-danger"></i> Delete</a></li>
                            @endcan
                        </x-actions>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </x-site>


@endsection

@section('script')
    <script type="text/javascript">

        $(function () {
            $('.warehouse').val("{{auth()->user()->warehouses_id}}").select2();

            $('.ediItem').click(function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                var name = $(this).data('name');
                var account_number = $(this).data('acnumber');
                var description = $(this).data('description');

                $('#ediModal form').attr('action', url);
                $('#ediModal [name=name]').val(name);
                $('#ediModal [name=account_number]').val(account_number);
                $('#ediModal [name=description]').val(description);
            });

            $('.payments').click(function (e) {
                e.preventDefault();
                var url = $(this).attr('href');

                $('#acModal form').attr('action', url);

                $('#acModal [name=amount]').val(0);

                $('.cheque_number').hide();
                $('.bank_account_no').hide();
                $('.transaction_no').hide();
            });

            $('.payment_method, .transaction_type').select2();

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
                    case "Customer Account":
                        $('.cheque_number').hide();
                        $('.bank_account_no').hide();
                        $('.transaction_no').hide();
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
                    { orderable: false, "targets": [6] }
                ]
            });
        });
    </script>
@endsection