@extends('layouts.master')
@extends('stock.box.units')

@section('title')
    Product Units
@endsection
@section('content')


    <x-site name="Product Units" body="New Product Units">
        <x-slot name="header">
            @can('Product Units Create')
                <button id="headerBtn" type="button" class="btn btn-primary heading-btn btn-labeled btn-labeled-left" data-toggle="modal" data-target="#myModal"><b><i class="icon-add-to-list"></i></b> Add New Units</button>
            @endcan
        </x-slot>

        <table class="table table-striped table-condensed table-hover datatable-basic">
            <thead>
            <tr>
                <th class="p-th">Name</th>
                <th class="p-th">Fill Name</th>
                <th class="text-right"><i class="icon-more"></i></th>
            </tr>
            </thead>
            <tbody>
            @foreach($table as $row)
                <tr>
                    <td class="p-td">{{$row->name}}</td>
                    <td class="p-td">{{$row->full_name}}</td>
                    <td class="text-right p-td">
                        <x-actions>
                            @can('Product Units Edit')
                                <li><a href="{{route('units.update', ['unit' => $row->id])}}"
                                   data-name="{{$row->name}}"
                                   data-fullname="{{$row->full_name}}"
                                   class="ediItem" data-toggle="modal" data-target="#ediModal"><i class="icon-pencil6 text-success"></i> Edit</a></li>
                            @endcan
                            @can('Product Units Delete')
                                <li><a href="{{route('units.destroy', ['unit' => $row->id])}}" class="delItem"><i class="icon-bin text-danger"></i> Delete</a></li>
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
                var full_name = $(this).data('fullname');

                $('#ediModal form').attr('action', url);
                $('#ediModal [name=name]').val(name);
                $('#ediModal [name=full_name]').val(full_name);

            });


            $('.datatable-basic').DataTable({
                columnDefs: [
                    { orderable: false, "targets": [2] }
                ]
            });
        });
    </script>
@endsection