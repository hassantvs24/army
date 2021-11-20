@extends('layouts.printx')

@section('title')
    Daily Sales Profit Calculation
@endsection
@section('content')
    <x-print header="Daily Sales Profit Calculation">
        <x-slot name="sub"><x-bp b="Date Range">{{$request['date_range']}}</x-bp></x-slot>
        <x-slot name="subr"><x-bp b="Report Date">{{date('d/m/Y')}}</x-bp></x-slot>

        <table class="table table-condensed table-bordered table-striped">
            <thead>
            <tr>
                <th>Date</th>
                <th>Total Invoice</th>
                <th>Discount</th>
                <th>Vat/Tax</th>
                <th>Other Cost</th>
                <th>Total Amount</th>
                <th>Purchase Cost</th>
                <th>Profit</th>
            </tr>
            </thead>
            <tbody>
            @php
                $invoice = 0;
                $discount = 0;
                $vet_tex = 0;
                $additional = 0;
                $purchase_total = 0;
                $subtotal = 0;
                $profit = 0;

            @endphp
            @foreach($table as $row)

                <tr>
                    <td>{{pub_date($row['date'])}}</td>
                    <td>{{$row['invoice']}}</td>
                    <td>{{money_c($row['discount_amount'])}}</td>
                    <td>{{money_c($row['vet_texes_amount'])}}</td>
                    <td>{{money_c($row['additional_charges'])}}</td>
                    <td>{{money_c($row['sub_total'])}}</td>
                    <td>{{money_c($row['purchase_total'])}}</td>
                    <td>{{money_c($row['sub_total'] - $row['purchase_total'])}}</td>
                </tr>

                @php
                    $invoice += $row['invoice'];
                    $discount += $row['discount_amount'];
                    $vet_tex += $row['vet_texes_amount'];
                    $additional += $row['additional_charges'];
                    $purchase_total += $row['purchase_total'];
                    $subtotal += $row['sub_total'];
                    $profit += ($row['sub_total'] - $row['purchase_total']);
                @endphp

            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th class="text-right">Total</th>
                <th>{{$invoice}}</th>
                <th>{{money_c($discount)}}</th>
                <th>{{money_c($vet_tex)}}</th>
                <th>{{money_c($additional)}}</th>
                <th>{{money_c($purchase_total)}}</th>
                <th>{{money_c($subtotal)}}</th>
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