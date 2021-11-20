@extends('layouts.printx')

@section('title')
    Product Stock Reports
@endsection
@section('content')
    <x-print header="Product Stock Reports">

        @if(!empty($request['stock_lower']))
            @if($request['stock_lower'] == 'limit'){
                @php
                    $tablex = $table->where('StockLower',1)->all();
                @endphp

           <x-slot name="sub"><x-bp b="Report">Lowe Stock Report</x-bp></x-slot>
            @else
                @php
                    $tablex = $table->where('CurrentStock', '<=', 0)->all();
                @endphp

                 <x-slot name="sub"><x-bp b="Report">Out of Stock Report</x-bp></x-slot>

            @endif
        @else
            @php
                $tablex = $table;
            @endphp

        @endif

        <x-slot name="subr"><x-bp b="Report Date">{{date('d/m/Y')}}</x-bp></x-slot>

        <table class="table table-condensed table-bordered table-striped">
            <thead>
            <tr>
                <th>S/N</th>
                <th>Name</th>
                <th>Type</th>
                <th>Category</th>
                <th>Company</th>
                <th>Sales Price</th>
                <th>Purchase Price</th>
                <th>Stock</th>
            </tr>
            </thead>
            <tbody>
            @php
                $sales = 0;
                $purchase = 0;
            @endphp
            @foreach($tablex as $row)
                <tr>
                    <td class="p-td">{{$row->sku}}</td>
                    <td class="p-td">{{$row->name}}</td>
                    <td class="p-td">{{$row->product_type}}</td>
                    <td class="p-td">{{$row->productCategory['name']}}</td>
                    <td class="p-td">{{$row->company['name']}}</td>
                    <td class="p-td">{{money_c($row->sell_price)}}</td>
                    <td class="p-td">{{money_c($row->purchase_price)}}</td>
                    <td class="p-td">{{$row->currentStock()}} {{$row->unit['name']}}</td>
                </tr>
                @php
                    $sales += ($row->currentStock() * $row->sell_price);
                    $purchase += ($row->currentStock() * $row->purchase_price);
                @endphp
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th></th>
                <th>
                    <p class="m-0"><b>Total Sales Value</b></p>
                    {{money_c($sales)}}
                </th>
                <th></th>
                <th></th>
                <th>
                    <p class="m-0"><b>Total Purchase Value</b></p>
                    {{money_c($purchase)}}
                </th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            </tfoot>
        </table>
    </x-print>

@endsection

@section('script')
    <script type="text/javascript">

    </script>
@endsection