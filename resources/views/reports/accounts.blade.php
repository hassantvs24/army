@extends('layouts.master')

@section('title')
    Account Book Report
@endsection
@section('content')
    <div class="row">
        <div class="col-md-5">
            <x-rpnl name="Account Book Report" action="{{route('reports.accounts_book')}}">
                <x-dinput class="date_pic" name="date_range" label="Date Range" required="required">
                    <x-slot name="addon"><i class="icon-calendar2"></i></x-slot>
                </x-dinput>

                <x-dselect label="Payment Method" class="pay_method" name="payment_method" required="">
                    <option value="">Select Payment Method (Optional)</option>
                    <option value="Cash">Cash</option>
                    <option value="Cheque">Cheque</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                </x-dselect>

                <x-dselect label="Account Book" class="accounts" name="account_books_id" required="">
                    <option value="">Select Account Book (Optional)</option>
                    @foreach($table as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
                </x-dselect>
            </x-rpnl>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">

        $(function () {
            $('.accounts, .pay_method').select2();

            $('.date_pic').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });
        });

    </script>
@endsection