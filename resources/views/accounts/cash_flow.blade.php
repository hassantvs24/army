@extends('layouts.master')
@section('title')
    Cash Flow
@endsection
@section('content')

    <x-page name="Cash Flow">

        <table class="table table-striped table-condensed table-hover datatable-basic">
            <thead>
            <tr>
                <th class="p-th">Date</th>
                <th class="p-th">Account</th>
                <th class="p-th">Method</th>
                <th class="p-th">Description</th>
                <th class="p-th">Credit</th>
                <th class="p-th">Debit</th>
                <th class="p-th">Balance</th>
            </tr>
            </thead>
            <tbody>
            @php
                $balance = 0;
                $credit = 0;
                $debit = 0;
            @endphp
            @foreach($table as $row)
                @php
                    $balance += $row->in() - $row->out();
                    $credit += $row->in();
                    $debit += $row->out();
                @endphp
                <tr>
                    <td class="p-td">{{pub_date($row->created_at)}}</td>
                    <td class="p-td">{{$row->accountBook['name']}}</td>
                    <td class="p-td">{{$row->payment_method}}</td>
                    <td class="p-td">{{$row->transaction_point}}: {{$row->transaction_hub}}</td>
                    <td class="p-td">{{money_c($row->in())}}</td>
                    <td class="p-td">{{money_c($row->out())}}</td>
                    <td class="p-td">{{money_c($balance)}}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr class="text-danger">
                <th class="text-right p-td" colspan="1">Total Credit</th>
                <th class="p-td">{{money_c($credit)}}</th>
                <th class="text-right p-td">Total Debit</th>
                <th class="p-td">{{money_c($debit)}}</th>
                <th class="text-right p-td">Total Balance</th>
                <th class="p-td">{{money_c($credit-$debit)}}</th>
                <th class="p-td"></th>
            </tr>
            </tfoot>
        </table>

    </x-page>


@endsection

@section('script')
    <script type="text/javascript">
        $(function () {
            $('.ediItem').click(function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                var name = $(this).data('name');
                var contact = $(this).data('contact');

                $('#ediModal form').attr('action', url);
                $('#ediModal [name=name]').val(name);
                $('#ediModal [name=contact]').val(contact);
            });


            $('.datatable-basic').DataTable({
                columnDefs: [
                    { orderable: false, "targets": [0,1,2,3,4,5,6] }
                ]
            });
        });
    </script>
@endsection