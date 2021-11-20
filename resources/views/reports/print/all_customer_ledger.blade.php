@extends('layouts.printx')

@section('title')
    Party Ledger Reports
@endsection
@section('content')
    <x-print header="Customer Ledger Report">
        <x-slot name="sub">
            <x-bp b="Date Range">{{$request['date_range']}}</x-bp>
        </x-slot>
        <x-slot name="subr"><x-bp b="Report Date">{{date('d/m/Y')}}</x-bp></x-slot>

        <table class="table table-condensed table-bordered table-striped">
            <thead>
            <tr>
                <th>Party Name</th>
                <th>Address</th>
                <!--<th>Qty</th>
                <th>Delivery Amount</th>-->
                <th>Collection</th>
                <th>Opening Balance</th>
                <th>Closing Balance</th>
                <th>Last Collection</th>
                <th>Cr. Limit</th>
                <th>Usable Balance</th>
                <th>Target</th>
                <!--<th>Agent</th>-->
            </tr>
            </thead>
            <tbody>

            @foreach($table as $row)
                @php

                    $op_collect_in = $row->transactions()
                     ->whereDate('created_at', '<', $st)
                     ->where('transaction_type', 'IN')
                     ->where('status', 'Active')
                     ->sum('amount');

                     $end_collect_in = $row->transactions()
                     ->whereDate('created_at', '<=', $end)
                     ->where('transaction_type', 'IN')
                     ->where('status', 'Active')
                     ->sum('amount');

                     $op_collect_out = $row->transactions()
                     ->whereDate('created_at', '<', $st)
                     ->where('transaction_type', 'OUT')
                     ->where('status', 'Active')
                     ->sum('amount');

                     $end_collect_out = $row->transactions()
                     ->whereDate('created_at', '<=', $end)
                     ->where('transaction_type', 'OUT')
                     ->where('status', 'Active')
                     ->sum('amount');

                     $op_collect = $op_collect_in - $op_collect_out;
                     $end_collect = $end_collect_in - $end_collect_out;

                      $op_invoices = $row->sellInvoices()
                     ->whereDate('created_at', '<', $st)
                     ->where('status', 'Final')
                     ->get();
                     $op_invoices_amount = $op_invoices->sum('SubTotal');

                     $end_invoices = $row->sellInvoices()
                     ->whereDate('created_at', '<=', $end)
                     ->where('status', 'Final')
                     ->get();
                     $end_invoices_amount = $end_invoices->sum('SubTotal');

                     $op_balance = $op_collect - $op_invoices_amount;

                     $end_balance = $end_collect - $end_invoices_amount;

                     $last_collect = $row->transactions()
                     ->whereBetween('created_at', $range)
                     ->where('transaction_type', 'IN')
                     ->where('status', 'Active')
                     ->orderBy('created_at', 'desc')
                     ->first();

                     $collect = $row->transactions()
                     ->whereBetween('created_at', $range)
                     ->where('transaction_type', 'IN')
                     ->where('status', 'Active')
                     ->sum('amount');

                     $invoices = $row->sellInvoices()
                     ->whereBetween('created_at', $range)
                     ->where('status', 'Final')
                     ->get();

                     /*$qty = 0;
                     $amount = 0;
                     foreach ($invoices as $rows){
                        $products = $rows->main_product();
                        $qty += $products['qty'];
                        $amount += $products['amount'];
                     }*/

                @endphp
                <tr>
                    <td>{{$row->name}}</td>
                    <td>{{$row->address}}</td>
                    <!--<td>{{--$qty--}}</td>
                    <td>{{--money_c($amount)--}}</td>-->
                    <td>{{money_c($collect)}}</td>
                    <td>{{money_c($op_balance)}}</td>
                    <td>{{money_c($end_balance)}}</td>
                    @if(isset($last_collect->created_at))
                        <td>{{pub_date($last_collect->created_at)}}</td>
                    @else
                        <td>--</td>
                    @endif
                    <td>{{money_c($row->credit_limit)}}</td>
                    <td>{{money_c($row->credit_limit + $end_balance)}}</td>
                    <td>{{$row->sells_target}}</td>
                    <!--<td>{{--$row->agent['name'] ?? ''--}}</td>-->

                </tr>
            @endforeach
            </tbody>
        </table>
    </x-print>

@endsection

@section('script')
    <script type="text/javascript">

    </script>
@endsection