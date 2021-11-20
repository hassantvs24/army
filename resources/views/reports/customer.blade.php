@extends('layouts.master')

@section('title')
    Customer Report
@endsection
@section('content')

    <div class="row">

        <div class="col-md-5">
            <x-rpnl name="Customer Ledger" action="{{route('reports.customer_single')}}">
                <x-dinput class="date_pic" name="date_range" label="Date Range" required="required">
                    <x-slot name="addon"><i class="icon-calendar2"></i></x-slot>
                </x-dinput>
                <x-dselect label="Customer" class="customer" name="customers_id" required="required">
                    <option value="">Select Customer</option>
                    @foreach($customer as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
                </x-dselect>

            </x-rpnl>
        </div>

        <div class="col-md-5">
            <x-rpnl name="All Party Ledger" action="{{route('reports.customer_all')}}">
                <x-dinput class="date_pic" name="date_range" label="Date Range" required="required">
                    <x-slot name="addon"><i class="icon-calendar2"></i></x-slot>
                </x-dinput>
                <x-dselect label="District" class="district" name="zillas_id" required="">
                    <option value="">Select District (Optional)</option>
                    @foreach($zilla as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
                </x-dselect>
                <x-dselect label="Sub-District" class="sub_district" name="upa_zillas_id" required="">
                    <option value="">Select Sub-District (Optional)</option>
                    @foreach($upazilla as $row)
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
            $('.district, .sub_district, .customer').select2();

            $('.date_pic').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });
        });
    </script>
@endsection