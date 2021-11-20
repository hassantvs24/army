@extends('layouts.printx')

@section('title')
    Sales Invoice Item Ledger
@endsection
@section('content')


    <x-print header="Sales Invoice Item Ledger Reports">
        <x-slot name="sub"><x-bp b="Date Range">{{$request['date_range']}}</x-bp></x-slot>
        <x-slot name="subr"><x-bp b="Report Date">{{date('d/m/Y')}}</x-bp></x-slot>

        <table class="table table-condensed table-bordered table-striped">
            <thead>
            <tr>
                <th>Date</th>
                <th>SKU</th>
                <th>Product</th>
                <th>Invoice No</th>
                <th>Quantity</th>
                <th>Purchase</th>
                <th>Rate</th>
                <th>Total</th>
                <th>Net Profit</th>
            </tr>
            </thead>
            <tbody>
            @php
                $total_sales = 0;
                $total_net_profit = 0;
            @endphp
            @foreach($table as $row)
                @php
                    $purchase_amount = ($row->purchase_amount != 0 ? $row->purchase_amount : $row->product['purchase_price']);
                    $net_profit = ($row->amount * $row->quantity) - ($purchase_amount * $row->quantity);
                @endphp
                <tr>
                    <td>{{pub_date($row->created_at)}}</td>
                    <td>{{$row->sku}}</td>
                    <td>{{$row->name}}</td>
                    <td>{{$row->sellInvoice['code']}}</td>
                    <td>{{$row->quantity}} {{$row->unit}}</td>
                    <td>{{money_c($purchase_amount)}}</td>
                    <td>{{money_c($row->amount)}}</td>
                    <td>{{money_c($row->amount * $row->quantity)}}</td>
                    <td>{{money_c($net_profit)}}</td>
                </tr>
                @php
                    $total_sales += ($row->amount * $row->quantity);
                    $total_net_profit += $net_profit;
                @endphp
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th class="text-right" colspan="7">Total</th>
                <th>{{money_c($total_sales)}}</th>
                <th>{{money_c($total_net_profit)}}</th>
            </tr>
            </tfoot>
        </table>
    </x-print>

@endsection

@section('script')
    <script type="text/javascript">

    </script>
@endsection