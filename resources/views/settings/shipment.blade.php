@extends('layouts.master')
@extends('settings.box.shipment')
@section('title')
    Shipment
@endsection
@section('content')

    <x-site name="Shipment">
        <x-slot name="header">
            @can('Shipment Create')
                <button id="headerBtn" type="button" class="btn btn-primary heading-btn btn-labeled btn-labeled-left" data-toggle="modal" data-target="#myModal"><b><i class="icon-add-to-list"></i></b> Add New Shipment</button>
            @endcan
        </x-slot>

        <table class="table table-striped table-condensed table-hover datatable-basic">
            <thead>
            <tr>
                <th class="p-th">Name</th>
                <th class="p-th">Company Name</th>
                <th class="p-th">Description</th>
                <th class="text-right"><i class="icon-more"></i></th>
            </tr>
            </thead>
            <tbody>
            @foreach($table as $row)
                <tr>
                    <td class="p-td">{{$row->name}}</td>
                    <td class="p-td">{{$row->shipping_company}}</td>
                    <td class="p-td">{{$row->description}}</td>
                    <td class="text-right p-td">
                        <x-actions>
                            @can('Shipment Edit')
                                <li><a href="{{route('shipment.update', ['shipment' => $row->id])}}"
                                   data-name="{{$row->name}}"
                                   data-company="{{$row->shipping_company}}"
                                   data-description="{{$row->description}}"
                                   class="ediItem" data-toggle="modal" data-target="#ediModal"><i class="icon-pencil6 text-success"></i> Edit</a></li>
                            @endcan
                            @can('Shipment Delete')
                                <li><a href="{{route('shipment.destroy', ['shipment' => $row->id])}}" class="delItem"><i class="icon-bin text-danger"></i> Delete</a></li>
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
                var shipping_company = $(this).data('company');
                var description = $(this).data('description');

                $('#ediModal form').attr('action', url);
                $('#ediModal [name=name]').val(name);
                $('#ediModal [name=shipping_company]').val(shipping_company);
                $('#ediModal [name=description]').val(description);

            });


            $('.datatable-basic').DataTable({
                columnDefs: [
                    { orderable: false, "targets": [3] }
                ]
            });
        });
    </script>
@endsection