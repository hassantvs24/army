@extends('layouts.printx')

@section('title')
    Customer Ledger Reports
@endsection
@section('content')
    <x-print header="Customer Ledger Report">
        <x-slot name="sub">
            <x-bp b="Customer">{{$table->name}}</x-bp>
            <x-bp b="Date Range">{{$request['date_range']}}</x-bp>
        </x-slot>
        <x-slot name="subr"><x-bp b="Report Date">{{date('d/m/Y')}}</x-bp></x-slot>

        <table class="table table-condensed table-bordered table-striped">
            <thead>
            <tr>
                <th>Date</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Balance</th>
            </tr>
            </thead>
            <tbody>
            @php
                $total = 0;
                $total_in = 0;
                $total_out = 0;
            @endphp
            @foreach($data as $row)
                @php
                    $total += ($row['in'] - $row['out']);
                    $total_in += $row['in'];
                    $total_out += $row['out'];
                @endphp
                <tr>
                    <td>{{pub_date($row['date'])}}</td>
                    <td>{{$row['in']}}</td>
                    <td>{{$row['out']}}</td>
                    <td>{{money_c($total)}}</td>
                </tr>

            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th class="text-right">Total</th>
                <th>{{money_c($total_in)}}</th>
                <th>{{money_c($total_out)}}</th>
                <th>{{money_c($total)}}</th>
            </tr>
            </tfoot>
        </table>
    </x-print>

@endsection

@section('script')
    <script type="text/javascript">

    </script>
@endsection