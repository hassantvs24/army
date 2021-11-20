@extends('layouts.printx')

@section('title')
    Balance Summery Reports
@endsection
@section('content')
    <x-print header="Balance Summery Reports">
        <x-slot name="sub"><x-bp b="Date Range">{{$request['date_range']}}</x-bp></x-slot>
        <x-slot name="subr"><x-bp b="Report Date">{{date('d/m/Y')}}</x-bp></x-slot>

        <table class="table table-condensed table-bordered table-striped">
            <thead>
            <tr>
                <th>Date</th>
                <th>Sales</th>
                <th>Purchase</th>
                <th>Expanse</th>
                <th>Recover</th>
                <th>Withdraw</th>
                <th>Deposit</th>
                <th>Balance</th>
            </tr>
            </thead>
            <tbody>
                @php
                    $sales = 0;
                    $purchase = 0;
                    $expense = 0;
                    $recover = 0;
                    $withdraw = 0;
                    $deposit = 0;
                    $profit = 0;

                @endphp
                @foreach($table as $row)
                    <tr>
                        <td>{{pub_date($row['date'])}}</td>
                        <td>{{money_c($row['sales'])}}</td>
                        <td>{{money_c($row['purchase'])}}</td>
                        <td>{{money_c($row['expense'])}}</td>
                        <td>{{money_c($row['recover'])}}</td>
                        <td>{{money_c($row['withdraw'])}}</td>
                        <td>{{money_c($row['deposit'])}}</td>
                        <td>{{money_c(($row['sales'] - $row['purchase'] - $row['expense'] + $row['recover'] - $row['withdraw'] + $row['deposit']))}}</td>
                    </tr>

                    @php
                        $sales += $row['sales'];
                        $purchase += $row['purchase'];
                        $expense += $row['expense'];
                        $recover += $row['recover'];
                        $withdraw += $row['withdraw'];
                        $deposit += $row['deposit'];
                        $profit += ($row['sales'] - $row['purchase'] - $row['expense'] + $row['recover'] - $row['withdraw'] + $row['deposit']);
                    @endphp

                @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th class="text-right">Total</th>
                <th>{{money_c($sales)}}</th>
                <th>{{money_c($purchase)}}</th>
                <th>{{money_c($expense)}}</th>
                <th>{{money_c($recover)}}</th>
                <th>{{money_c($withdraw)}}</th>
                <th>{{money_c($deposit)}}</th>
                <th>{{money_c($profit)}}</th>
            </tr>
            </tfoot>
        </table>
    </x-print>

@endsection

@section('script')
    <script type="text/javascript">

    </script>
@endsection