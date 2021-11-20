@extends('layouts.master')

@section('title')
    Stock Transaction
@endsection
@section('content')


    <x-page name="Stock Transaction">

        <table class="table table-striped table-condensed table-hover datatable-basic">
            <thead>
            <tr>
                <th class="p-th">Date</th>
                <th class="p-th">SKU</th>
                <th class="p-th">Name</th>
                <th class="p-th">Transaction Point</th>
                <th class="p-th">IN</th>
                <th class="p-th">OUT</th>
                <th class="p-th">Unit</th>
            </tr>
            </thead>
            <tbody>
            @php
                $in = 0;
                $out = 0;
            @endphp
            @foreach($table as $row)
                <tr>
                    <td class="p-td">{{pub_date($row->created_at)}}</td>
                    <td class="p-td">{{$row->sku}}</td>
                    <td class="p-td">{{$row->name}}</td>
                    <td class="p-td">{{$row->transaction_point}}</td>
                    <td class="p-td">{{$row->in()}}</td>
                    <td class="p-td">{{$row->out()}}</td>
                    <td class="p-td">{{$row->unit}}</td>
                </tr>
                @php
                    $in += $row->in();
                    $out += $row->out();
                @endphp
            @endforeach
            </tbody>
            <tfoot>
                <tr class="text-danger">
                    <th class="text-right p-td" colspan="1">Total IN</th>
                    <th class="p-td">{{money_c($in)}}</th>
                    <th class="text-right p-td">Total OUT</th>
                    <th class="p-td">{{money_c($out)}}</th>
                    <th class="text-right p-td">Total Stock</th>
                    <th class="p-td">{{money_c($in-$out)}}</th>
                    <th class="p-td"></th>
                </tr>
            </tfoot>
        </table>

    </x-page>


@endsection

@section('script')
    <script type="text/javascript">
        $(function () {

            $('.datatable-basic').DataTable({
                columnDefs: [
                   // { orderable: false, "targets": [3] }
                ]
            });
        });
    </script>
@endsection