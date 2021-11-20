@extends('layouts.master')
@extends('customer.box.agent')

@section('title')
    Agent List
@endsection

@section('content')

    <x-site name="Agent List">
        <x-slot name="header">
            @can('Agent Create')
                <button id="headerBtn" type="button" class="btn btn-primary heading-btn btn-labeled btn-labeled-left" data-toggle="modal" data-target="#myModal"><b><i class="icon-add-to-list"></i></b> Add New Agent</button>
            @endcan
        </x-slot>

        <table class="table table-striped table-condensed table-hover datatable-basic">
            <thead>
            <tr>
                <th class="p-th">S/N</th>
                <th class="p-th">Agent Name</th>
                <th class="p-th">Warehouse</th>
                <th class="text-right"><i class="icon-more"></i></th>
            </tr>
            </thead>
            <tbody>
            @foreach($table as $row)
                <tr>
                    <td class="p-td">{{$row->code}}</td>
                    <td class="p-td">{{$row->name}}</td>
                    <td class="p-td">{{$row->warehouse['name']}}</td>
                    <td class="text-right p-td">
                        <x-actions>
                            @can('Agent Edit')
                                <li><a href="{{route('agent.update', ['agent' => $row->id])}}"
                                   data-name="{{$row->name}}"
                                   data-code="{{$row->code}}"
                                   data-warehouses="{{$row->warehouses_id}}"
                                   class="ediItem" data-toggle="modal" data-target="#ediModal"><i class="icon-pencil6 text-success"></i> Edit</a></li>
                            @endcan
                            @can('Agent Delete ')
                                <li><a href="{{route('agent.destroy', ['agent' => $row->id])}}" class="delItem"><i class="icon-bin text-danger"></i> Delete</a></li>
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
                var warehouses_id = $(this).data('warehouses');
                var code = $(this).data('code');

                $('#ediModal form').attr('action', url);
                $('#ediModal [name=name]').val(name);
                $('#ediModal [name=code]').val(code);
                $('#ediModal [name=warehouses_id]').val(warehouses_id).select2();
            });

            $('.warehouse').val("{{auth()->user()->warehouses_id}}").select2();

            $('.datatable-basic').DataTable({
                columnDefs: [
                    { orderable: false, "targets": [3] }
                ]
            });
        });
    </script>
@endsection