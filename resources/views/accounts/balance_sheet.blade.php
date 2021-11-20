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
                <th>Liability</th>
                <th>Assets</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="vertical-align: top;">
                        <p><b>Supplier Due:</b> {{money_c($supplier_due)}}</p>
                    </td>
                    <td style="vertical-align: top;">
                        <p><b>Customer Due:</b> {{money_c($customer_due)}}</p>
                        <p><b>Closing Stock:</b> {{money_c($stock_value)}}</p>
                        <p><b>Account Balance:</b> <br />
                            @php
                                $ac_balance = 0;
                            @endphp
                            @foreach($table as $row)
                                <p class="pl-20">{{$row->name}}: {{money_c($row->acBalance())}}</p>
                                @php
                                    $ac_balance += $row->acBalance();
                                @endphp
                            @endforeach
                        </p>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th><b>Total Liability:	</b> {{money_c($total_liability)}}</th>
                    <th><b>Total Assets: </b> {{money_c($total_asset + $ac_balance)}}</th>
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