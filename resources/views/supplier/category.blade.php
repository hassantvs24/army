@extends('layouts.master')
@extends('supplier.box.category')

@section('title')
    Supplier Category
@endsection

@section('content')


    <x-site name="Supplier Category">

        <x-slot name="header">
            @can('Supplier Category Create')
                <button id="headerBtn" type="button" class="btn btn-primary heading-btn btn-labeled btn-labeled-left" data-toggle="modal" data-target="#myModal"><b><i class="icon-add-to-list"></i></b> Add New Supplier Category</button>
            @endcan
        </x-slot>


        <table class="table table-striped table-condensed table-hover datatable-basic">
            <thead>
            <tr>
                <th class="p-th">Code</th>
                <th class="p-th">Supplier Category Name</th>
                <th class="text-right"><i class="icon-more"></i></th>
            </tr>
            </thead>
            <tbody>
            @foreach($table as $row)
                <tr>
                    <td class="p-td">{{$row->code}}</td>
                    <td class="p-td">{{$row->name}}</td>
                    <td class="text-right p-td">
                        <x-actions>
                            @can('Supplier Category Edit')
                                <li><a href="{{route('supplier-category.update', ['category' => $row->id])}}"
                                   data-name="{{$row->name}}"
                                   data-code="{{$row->code}}"
                                   class="ediItem" data-toggle="modal" data-target="#ediModal"><i class="icon-pencil6 text-success"></i> Edit</a></li>
                            @endcan
                            @can('Supplier Category Delete')
                                <li><a href="{{route('supplier-category.destroy', ['category' => $row->id])}}" class="delItem"><i class="icon-bin text-danger"></i> Delete</a></li>
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
                var code = $(this).data('code');

                $('#ediModal form').attr('action', url);
                $('#ediModal [name=name]').val(name);
                $('#ediModal [name=code]').val(code);

            });


            $('.datatable-basic').DataTable({
                columnDefs: [
                    { orderable: false, "targets": [2] }
                ]
            });
        });
    </script>
@endsection