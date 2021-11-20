@extends('layouts.printx')

@section('title')
    Purchase Invoice Item Ledger
@endsection
@section('content')


    <x-print header="Purchase Invoice Item Ledger Reports">
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
                <th>Unit</th>
                <th>Rate</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            @php
                $total_sales = 0;
            @endphp
            @foreach($table as $row)
                <tr>
                    <td>{{pub_date($row->created_at)}}</td>
                    <td>{{$row->sku}}</td>
                    <td>{{$row->name}}</td>
                    <td>{{$row->purchaseInvoice['code']}}</td>
                    <td>{{$row->quantity}}</td>
                    <td>{{$row->unit}}</td>
                    <td>{{money_c($row->amount)}}</td>
                    <td>{{money_c($row->amount * $row->quantity)}}</td>
                </tr>
                @php
                    $total_sales += ($row->amount * $row->quantity);
                @endphp
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th class="text-right" colspan="7">Total Sales</th>
                <th>{{money_c($total_sales)}}</th>
            </tr>
            </tfoot>
        </table>
    </x-print>

@endsection

@section('script')
    <script type="text/javascript">

    </script>
@endsection