@extends('layouts.master')
@extends('accounts.box.transaction')
@section('title')
    {{$table->name}} - Payment Transaction
@endsection
@section('content')

    <x-site name="{{$table->name}}">

        <x-slot name="header">
            <a href="{{route('accounts.index')}}" class="btn btn-danger heading-btn btn-labeled btn-labeled-left"><b><i class="icon-arrow-left5"></i></b> Back to account list</a>
            @can('Transaction Create')
                <button id="headerBtn" type="button" class="btn btn-primary heading-btn btn-labeled btn-labeled-left" data-toggle="modal" data-target="#myModal"><b><i class="icon-add-to-list"></i></b> Make Transaction</button>
            @endcan
        </x-slot>

        <table class="table table-striped table-condensed table-hover datatable-basic">
            <thead>
            <tr>
                <th class="p-th">Date</th>
                <th class="p-th">Method</th>
                <th class="p-th">Payment No</th>
                <th class="p-th">Description</th>
                <th class="p-th">Section</th>
                <th class="p-th">Purpose</th>
                <th class="p-th">Credit</th>
                <th class="p-th">Debit</th>
                <th class="text-right"><i class="icon-more"></i></th>
            </tr>
            </thead>
            <tbody>

            @foreach($transactions as $row)
                <tr>
                    <td class="p-td">{{pub_date($row->created_at)}}</td>
                    <td class="p-td">{{$row->payment_method}}</td>
                    <td class="p-td" title="{{$row->payment_number()['title']}}">{{$row->payment_number()['numbers']}}</td>
                    <td class="p-td" title="Bank name or Other note">{{$row->description}}</td>
                    <td class="p-td">{{$row->transaction_point}}</td>
                    <td class="p-td">{{$row->transaction_hub}}</td>
                    <td class="p-td">{{money_c($row->in())}}</td>
                    <td class="p-td">{{money_c($row->out())}}</td>
                    <td class="text-right p-td">
                        <x-actions>
                            @can('Transaction Edit')
                                <li><a href="{{route('transactions.update', ['transaction' => $row->id])}}"
                                   data-acbook="{{$row->account_books_id}}"
                                   data-pmethod="{{$row->payment_method}}"
                                   data-cheque="{{$row->cheque_number}}"
                                   data-bac="{{$row->bank_account_no}}"
                                   data-trno="{{$row->transaction_no}}"
                                   data-trhub="{{$row->transaction_hub}}"
                                   data-point="{{$row->transaction_point}}"
                                   data-trtype="{{$row->transaction_type}}"
                                   data-description="{{$row->description}}"
                                   data-amount="{{$row->amount}}"
                                   data-warehouse="{{$row->warehouses_id}}"
                                   data-crdate="{{pub_date($row->created_at)}}"
                                   class="ediItem" data-toggle="modal" data-target="#ediModal"><i class="icon-pencil6 text-success"></i> Edit</a></li>
                                <li><a href="{{route('transactions.destroy', ['transaction' => $row->id])}}" class="delItem"><i class="icon-bin text-danger"></i> Delete</a></li>
                            @endcan
                        </x-actions>
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr class="text-danger">
                    <th class="text-right p-td" colspan="3">Total Credit</th>
                    <th class="p-td">{{money_c($table->in())}}</th>
                    <th class="text-right p-td">Total Debit</th>
                    <th class="p-td">{{money_c($table->out())}}</th>
                    <th class="text-right p-td">Total Balance</th>
                    <th class="p-td">{{money_c($table->acBalance())}}</th>
                    <th class="p-td"></th>
                </tr>
            </tfoot>
        </table>

    </x-site>


@endsection

@section('script')
    <script type="text/javascript">

        $(function () {
                $('.warehouse').val("{{auth()->user()->warehouses_id}}").select2();

                $('.payment_method, .transaction_type').select2();

            $('.ediItem').click(function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                var transaction_type = $(this).data('trtype');
                var account_books_id = $(this).data('acbook');
                var payment_method = $(this).data('pmethod');
                var cheque_number = $(this).data('cheque');
                var bank_account_no = $(this).data('bac');
                var transaction_no = $(this).data('trno');
                var description = $(this).data('description');
                var transaction_hub = $(this).data('trhub');
                var transaction_point = $(this).data('point');
                var amount = $(this).data('amount');
                var warehouses_id = $(this).data('warehouse');
                var created_at = $(this).data('crdate');


                $('#ediModal form').attr('action', url);
                $('#ediModal [name=account_books_id]').val(account_books_id);
                $('#ediModal [name=transaction_type]').val(transaction_type);
                $('#ediModal [name=cheque_number]').val(cheque_number);
                $('#ediModal [name=bank_account_no]').val(bank_account_no);
                $('#ediModal [name=transaction_no]').val(transaction_no);
                $('#ediModal [name=amount]').val(amount);
                $('#ediModal [name=description]').val(description);
                $('#ediModal [name=transaction_hub]').val(transaction_hub);
                $('#ediModal [name=transaction_point]').val(transaction_point);
                $('#ediModal [name=created_at]').val(created_at);

                $('#ediModal [name=transaction_type]').val(transaction_type).select2();
                $('#ediModal [name=warehouses_id]').val(warehouses_id).select2();
                $('#ediModal [name=payment_method]').val(payment_method).select2();

                var methods = $('#ediModal [name=payment_method]').val();
                pay_method(methods);

                $('#ediModal [name=payment_method]').change(function () {
                    var methodss = $(this).val();
                    pay_method(methodss);
                });

            });


                $('.payment_method').change(function () {
                    var methods = $(this).val();
                    pay_method(methods);
                });

                $('.date_pic').daterangepicker({
                    singleDatePicker: true,
                    locale: {
                        format: 'DD/MM/YYYY'
                    }
                });

            $('.datatable-basic').DataTable({
                columnDefs: [
                     { orderable: false, "targets": [7] }
                ]
            });
        });

        function pay_method(methods) {

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
        }

    </script>
@endsection