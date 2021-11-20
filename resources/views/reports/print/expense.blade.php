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
                    <th>S/N</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
            @php
                $total = 0;
            @endphp
            @foreach($table as $row)
                <tr>
                    <td>{{pub_date($row->created_at)}}</td>
                    <td>{{$row->code}}</td>
                    <td>{{$row->expenseCategory['name']}}</td>
                    <td>{{$row->description}}</td>
                    <td>{{money_c($row->amount)}}</td>
                </tr>
                @php
                    $total += $row->amount;
                @endphp
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th class="text-right" colspan="4">Total</th>
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