@extends('layouts.printx')

@section('title')
    Expense Reports
@endsection
@section('content')
    <x-print header="Expanse Report">
        <x-slot name="sub"><x-bp b="Date Range">{{$request['date_range']}}</x-bp></x-slot>
        <x-slot name="subr"><x-bp b="Report Date">{{date('d/m/Y')}}</x-bp></x-slot>

        <table class="table table-condensed table-bordered table-striped">
            <thead>
            <tr>
                <th>Date</th>
                <th>Account Book</th>
                <th>Method</th>
                <th>Payment No</th>
                <th>Description</th>
                <th>Section</th>
                <th>Purpose</th>
                <th>Credit</th>
                <th>Debit</th>
                <th>Balance</th>
            </tr>
            </thead>
            <tbody>
            @php
                $in = 0;
                $out = 0;
                $total = 0;
            @endphp
            @foreach($table as $row)
                @php
                    $in += $row->in();
                    $out += $row->out();
                    $total += ($row->in() - $row->out());
                @endphp
                <tr>
                    <td>{{pub_date($row->created_at)}}</td>
                    <td>{{$row->accountBook['name'] ?? ''}}</td>
                    <td>{{$row->payment_method}}</td>
                    <td>{{$row->payment_number()['numbers']}}</td>
                    <td>{{$row->description}}</td>
                    <td>{{$row->transaction_point}}</td>
                    <td>{{$row->transaction_hub}}</td>
                    <td>{{money_c($row->in())}}</td>
                    <td>{{money_c($row->out())}}</td>
                    <td>{{money_c($total)}}</td>
                </tr>

            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th class="text-right" colspan="7">Total</th>
                <th>{{money_c($in)}}</th>
                <th>{{money_c($out)}}</th>
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