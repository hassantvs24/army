@extends('layouts.master')

@section('title')
    Sales Report
@endsection
@section('content')

    <div class="row">

        <div class="col-md-5">
            <x-rpnl name="Sales Invoice" action="{{route('reports.sales_invoice')}}">
                <x-dinput class="date_pic" name="date_range" label="Date Range" required="required">
                    <x-slot name="addon"><i class="icon-calendar2"></i></x-slot>
                </x-dinput>
                <x-dselect label="Customer" class="customer" name="customers_id" required="">
                    <option value="">Select Customer (Optional)</option>
                    @foreach($customer as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
                </x-dselect>

                <x-dselect label="Agents" class="agent" name="agents_id" required="">
                    <option value="">Select Agent (Optional)</option>
                    @foreach($agent as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
                </x-dselect>

                <x-check name="due" value="due" label="Due Invoice List" />

            </x-rpnl>
        </div>

        <div class="col-md-5">
            <x-rpnl name="Sales Invoice Item" action="{{route('reports.sales_items')}}">
                <x-dinput class="date_pic" name="date_range" label="Date Range" required="required">
                    <x-slot name="addon"><i class="icon-calendar2"></i></x-slot>
                </x-dinput>
                <x-dselect label="Product" class="products" name="products_id" required="">
                    <option value="">Select Product (Optional)</option>
                    @foreach($products as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
                </x-dselect>
            </x-rpnl>
        </div>

    </div>

    <div class="row">


        <div class="col-md-5">
            <x-rpnl name="All Due Invoice List" action="{{route('reports.sales_invoice_due')}}">
                <x-dselect label="Customer" class="customer" name="customers_id" required="">
                    <option value="">Select Customer (Optional)</option>
                    @foreach($customer as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
                </x-dselect>
                <x-dselect label="Due status" class="due" name="due" required="required">
                    <option value="Due">Due Invoice List</option>
                    <option value="Over">Over Due Invoice List</option>
                </x-dselect>
            </x-rpnl>
        </div>

    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(function () {
            $('.products, .customer, .agent, .due').select2();

            $('.date_pic').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });
        });
    </script>
@endsection