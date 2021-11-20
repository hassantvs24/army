@extends('layouts.printx')

@section('title')
     Sales Due Invoice
@endsection
@section('content')


    <x-print header="Sales Due Invoice Report">
        <x-slot name="sub">
            @if($request['due'] == 'Over')
                <x-bp b="Report">Over Due Invoice Report</x-bp>
            @endif
        </x-slot>

        <x-slot name="subr"><x-bp b="Report Date">{{date('d/m/Y')}}</x-bp></x-slot>

        <table class="table table-condensed table-bordered table-striped">
            <thead>
            <tr>
                <th>Date</th>
                <th>S/N</th>
                <th>Customer</th>
                <th>Contact</th>
                <th>Due Date</th>
                <th>Amount</th>
                <th>Paid</th>
                <th>Due</th>
                <th>Due Adj.</th>
            </tr>
            </thead>
            <tbody>

            @php
                   $tablex = $table->where('BalanceDue', '>', 0)->all();
                   $total = 0;
                   $total_inv_paid = 0;
                   $total_inv_due = 0;
                   $total_inv_bal_due = 0;
                   $i = 0;
            @endphp
            @foreach($tablex as $row)
                <tr>
                    <td>{{pub_date($row->created_at)}}</td>
                    <td>{{$row->code}}</td>
                    <td>{{$row->name}}</td>
                    <td>{{$row->contact}}</td>
                    @if(isset($row->due_date))
                        <td>{{pub_date($row->due_date)}}</td>
                    @else
                        <td></td>
                    @endif
                    <td>{{money_c($row->invoice_sub_total())}}</td>
                    <td>{{money_c($row->invoice_paid())}}</td>
                    <td>{{money_c($row->invoice_due())}}</td>
                    <td>{{money_c($row->balance_due())}}</td>
                </tr>
                @php
                    $total += $row->invoice_sub_total();
                    $total_inv_paid += $row->invoice_paid();
                    $total_inv_due += $row->invoice_due();
                    $total_inv_bal_due += $row->balance_due();
                    $i++;
                @endphp
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th class="text-right" colspan="5">Total({{$i}})</th>
                <th>{{money_c($total)}}</th>
                <th>{{money_c($total_inv_paid)}}</th>
                <th>{{money_c($total_inv_due)}}</th>
                <th>{{money_c($total_inv_bal_due)}}</th>
            </tr>
            </tfoot>
        </table>
    </x-print>

@endsection

@section('script')
    <script type="text/javascript">

    </script>
@endsection