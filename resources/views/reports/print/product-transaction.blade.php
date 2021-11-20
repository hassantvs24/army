@extends('layouts.printx')

@section('title')
    Stock Transaction Reports
@endsection
@section('content')
    <x-print header="Stock Transaction Reports">
        <x-slot name="sub"><x-bp b="Date Range">{{$request['date_range']}}</x-bp></x-slot>
        <x-slot name="subr"><x-bp b="Report Date">{{date('d/m/Y')}}</x-bp></x-slot>

        <table class="table table-condensed table-bordered table-striped">
            <thead>
            <tr>
                <th>Date</th>
                <th>SKU</th>
                <th>Name</th>
                <th>Ref</th>
                <th>Unit</th>
                <th>IN</th>
                <th>OUT</th>
            </tr>
            </thead>
            <tbody>
            @php
                $total_in = 0;
                $total_out = 0;
            @endphp
            @foreach($table as $row)
                <tr>
                    <td>{{pub_date($row->created_at)}}</td>
                    <td>{{$row->sku}}</td>
                    <td>{{$row->name}}</td>
                    <td>{{$row->transaction_point}}</td>
                    <td>{{$row->unit}}</td>
                    <td>{{$row->in()}}</td>
                    <td>{{$row->out()}}</td>
                </tr>
                @php
                    $total_in += $row->in();
                    $total_out += $row->out();
                @endphp
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th class="text-right" colspan="5">Total</th>
                <th>{{$total_in}}</th>
                <th>{{$total_out}}</th>
            </tr>
            </tfoot>
        </table>
    </x-print>

@endsection

@section('script')
    <script type="text/javascript">

    </script>
@endsection