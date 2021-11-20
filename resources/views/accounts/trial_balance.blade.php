@extends('layouts.master')
@extends('box.welcome')

@section('title')
    Balance Sheet
@endsection
@section('content')


    <x-panel name="Balance Sheet">

        <table class="table table-striped table-bordered table-condensed table-hover">
            <thead>
            <tr>
                <th>Trial Balance</th>
                <th>Credit</th>
                <th>Debit</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Supplier Due:</th>
                    <td></td>
                    <td>{{money_c($supplier_due)}}</td>
                </tr>
                <tr>
                    <th>Customer Due:</th>
                    <td>{{money_c($customer_due)}}</td>
                    <td></td>
                </tr>
                <tr>
                    <th>Account Balances:</th>
                    <td></td>
                    <td></td>
                </tr>
                @php
                    $ac_balance = 0;
                @endphp
                @foreach($table as $row)
                    <tr>
                        <td><span class="pl-20">{{$row->name}}:</span></td>
                        <td>{{money_c($row->acBalance())}}</td>
                        <td></td>
                    </tr>
                    @php
                        $ac_balance += $row->acBalance();
                    @endphp
                @endforeach

            </tbody>
            <tfoot>
            <tr>
                <th>Total</th>
                <td>{{money_c($credit + $ac_balance)}}</td>
                <td>{{money_c($debit)}}</td>
            </tr>
            </tfoot>
        </table>

    </x-panel>


@endsection

@section('script')
    <script type="text/javascript">
        $(function () {

        });
    </script>
@endsection