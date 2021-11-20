@extends('layouts.master')
@extends('settings.box.vat_tax')
@section('title')
    Vat Tax
@endsection
@section('content')

    <x-site name="Vat Tax Setup">
        <x-slot name="header">
            @can('Vat Create')
                <button id="headerBtn" type="button" class="btn btn-primary heading-btn btn-labeled btn-labeled-left" data-toggle="modal" data-target="#myModal"><b><i class="icon-add-to-list"></i></b> Add New Vat Tax</button>
            @endcan
        </x-slot>

        <table class="table table-striped table-condensed table-hover datatable-basic">
            <thead>
            <tr>
                <th class="p-th">Name</th>
                <th class="p-th">Vat Amount (%)</th>
                <th class="text-right"><i class="icon-more"></i></th>
            </tr>
            </thead>
            <tbody>
            @foreach($table as $row)
                <tr>
                    <td class="p-td">{{$row->name}}</td>
                    <td class="p-td">{{$row->amount}}</td>
                    <td class="text-right p-td">
                        <x-actions>
                            @can('Vat Edit')
                                <li><a href="{{route('vat-tax.update', ['vat_tax' => $row->id])}}"
                                   data-name="{{$row->name}}"
                                   data-amount="{{$row->amount}}"
                                   class="ediItem" data-toggle="modal" data-target="#ediModal"><i class="icon-pencil6 text-success"></i> Edit</a></li>
                            @endcan
                            @can('Vat Delete')
                                <li><a href="{{route('vat-tax.destroy', ['vat_tax' => $row->id])}}" class="delItem"><i class="icon-bin text-danger"></i> Delete</a></li>
                            @endcan
                        </x-actions>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </x-site>

@endsection

@section('script')
    <script type="text/javascript">

        $(function () {
            $('.ediItem').click(function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                var name = $(this).data('name');
                var amount = $(this).data('amount');

                $('#ediModal form').attr('action', url);
                $('#ediModal [name=name]').val(name);
                $('#ediModal [name=amount]').val(amount);

            });


            $('.datatable-basic').DataTable({
                columnDefs: [
                    { orderable: false, "targets": [2] }
                ]

            });
        });

    </script>
@endsection