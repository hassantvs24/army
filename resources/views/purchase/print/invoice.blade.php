@extends('layouts.print')

@section('title')
    Purchase Invoice
@endsection

@section('footer')
    <x-signature left="Supplier Signature" right="Authorize Signature" />
    <x-print-footer></x-print-footer>
@endsection

@section('content')
    <div id="header">
        <div id="logo">
            <!--<img src="{{asset('public/')}}/logo_{{$table->warehouse->getRawOriginal('logo') ?? $table->business->getRawOriginal('logo')}}" alt="Logo">-->
        </div>
        <div id="reference">
            <h3><strong>BILL</strong></h3>
            <h4>S/N : {{$table->code}}</h4>
            <p>Date : {{ pub_date($table->created_at) }}</p>
        </div>
    </div>

    <div id="fromto">
        <div id="from">
            <p>
                <strong>{{$table->warehouse['name'] ?? $table->business['name']}}</strong><br />
                {{$table->warehouse['address'] ?? $table->business['address']}}<br />
                Cell: {{$table->warehouse['contact'] ?? $table->business['contact']}} <br />
                Email: {{$table->warehouse['email'] ?? $table->business['email']}} <br />
                Web: {{$table->warehouse['website'] ?? $table->business['website']}}
            </p>
        </div>
        <div id="to">
            <p>
                <strong>{{$table->name}}</strong><br />
                {{$table->address}}<br />
                Cell: {{$table->contact}}<br />
                Email: {{$table->email}} <br /><br />
                <hr />
                <p><strong>Invoice Due: {{money_c($table->invoice_due())}}</strong></p>
                <p><strong>Due Adjustment: {{money_c($table->balance_due())}}</strong></p>
            </p>
        </div>
    </div>

    <div id="items">
        <table>
            <tr>
                <th>Description</th>
                <th>Rate</th>
                <th>Qty</th>
                <th>Total</th>
            </tr>
            @php
                $items = $table->purchaseItems()->get();
            @endphp
            @foreach($items as $row)
                <tr>
                    <td>{{$row->name}} - {{$row->product->productCategory['name'] ?? ''}}</td>
                    <td>{{money_c($row->amount)}}</td>
                    <td>{{$row->quantity}} {{$row->unit}}</td>
                    <td>{{money_c($row->amount * $row->quantity)}}</td>
                </tr>
            @endforeach
            <tfoot>
                <tr>
                    <th colspan="3" style="text-align: right;">Total </th>
                    <th>{{money_c($table->invoice_total())}}</th>
                </tr>
            </tfoot>
        </table>
        <p><b>In word: </b>{{in_word($table->invoice_sub_total())}}</p>
    </div>

    <div id="summary">
        <div id="note">
            <h4>Note :</h4>
            <p>{{$table->description}}</p>
        </div>
        <div id="total">
            <table border="1">
                <tr>
                    <td>Discount</td>
                    <td>{{money_c($table->discount_amount)}}</td>
                </tr>
                <tr>
                    <td>Total VAT</td>
                    <td>{{money_c($table->vet_texes_amount)}}</td>
                </tr>
                <tr>
                    <td>Other Cost</td>
                    <td>{{money_c($table->additional_charges)}}</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td>{{money_c($table->invoice_sub_total())}}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection


