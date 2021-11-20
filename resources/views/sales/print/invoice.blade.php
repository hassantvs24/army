@extends('layouts.print')

@section('title')
    Sales Invoice
@endsection

@section('footer')
    {{--<x-signature left="Customer Signature" right="Customer Signature" />--}}
    <x-print-footer>Infinity Flame Soft Rongmohol Tower, Bondor Bazar 3100 Sylhet Tel: +880 1675 870047 Email: contact@website.com Web: www.website.com</x-print-footer>
@endsection

@section('content')
    <div id="header">
        <div id="logo">
            <img src="{{asset('public/')}}/logo_{{$table->warehouse->getRawOriginal('logo') ?? $table->business->getRawOriginal('logo')}}" alt="Logo">
        </div>
        <div id="reference">
            <h3><strong>Invoice</strong></h3>
            <h4>S/N : {{$table->code}}</h4>
            <p>Date : {{ pub_date($table->created_at) }}</p>
        </div>
    </div>

    <div id="fromto">
        <div id="from">
            <p>
                <strong>{{$table->warehouse['name'] ?? $table->business['name']}}</strong><br />
                {{$table->warehouse['address'] ?? $table->business['address']}}<br />
                Mobile: {{$table->warehouse['contact'] ?? $table->business['contact']}} <br />
                Email: {{$table->warehouse['email'] ?? $table->business['email']}} <br />
                Web: {{$table->warehouse['website'] ?? $table->business['website']}}
            </p>
        </div>
        <div id="to">
            <p>
                <strong>{{$table->name}}</strong><br />
                {{$table->address}}<br />
                Cell: {{$table->contact}}<br />
                Customer ID: {{$table->code}}
            </p>
            @php
                $t_due = $table->customer->dueBalancex() ?? 0;
                $inv_due = $table->invoice_due();
            @endphp
            <hr />
            <p>
                <strong>Previous Due</strong> {{money_c($t_due - $inv_due)}}
            </p>
        </div>
    </div>

    <div id="items">
        <table>
            <tr>
                <th>Description</th>
                <th>Rate</th>
                <th>Less</th>
                <th>Qty</th>
                <th>Total</th>
            </tr>
            @php
                $items = $table->invoiceItems()->get();
            @endphp
            @foreach($items as $row)

                <tr>
                    <td>{{$row->name}} {{$row->product->productCategory->name ?? ''}}</td>
                    <td>{{money_c($row->getAttributes()['amount'])}}</td>
                    <td>{{$row->discount_amount}}{{$row->discount_type == 'Percentage' ? '%':''}}</td>
                    <td>{{$row->quantity}} {{$row->unit}}</td>
                    <td>{{money_c($row->amount * $row->quantity)}}</td>
                </tr>
            @endforeach
            <tfoot>
            <tr>
                <th colspan="4" style="text-align: right;">Total </th>
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
                <tr>
                    <td>Total Paid</td>
                    <td>{{money_c($table->invoice_paid())}}</td>
                </tr>
                <tr>
                    <td>Invoice Due</td>
                    <td>{{money_c($table->invoice_due())}}</td>
                </tr>
                <tr>
                    <td>Total Due</td>
                    <td>{{money_c($table->customer->dueBalancex() ?? 0)}}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection


