@extends('layouts.master')
@extends('customer.box.sub_district')

@section('title')
    Sub District
@endsection

@section('content')

    <x-site name="Sub District">
        <x-slot name="header">
            @can('SubDistrict Create')
                <button id="headerBtn" type="button" class="btn btn-primary heading-btn btn-labeled btn-labeled-left" data-toggle="modal" data-target="#myModal"><b><i class="icon-add-to-list"></i></b> Add New Sub District</button>
            @endcan
        </x-slot>

        <table class="table table-striped table-condensed table-hover datatable-basic">
            <thead>
            <tr>
                <th class="p-th">Sub District</th>
                <th class="p-th">District</th>
                <th class="text-right"><i class="icon-more"></i></th>
            </tr>
            </thead>
            <tbody>
            @foreach($table as $row)
                <tr>
                    <td class="p-td">{{$row->name}}</td>
                    <td class="p-td">{{$row->zilla['name']}}</td>
                    <td class="text-right p-td">
                        <x-actions>
                            @can('SubDistrict Edit')
                                <li><a href="{{route('sub-district.update', ['sub_district' => $row->id])}}"
                                   data-name="{{$row->name}}"
                                   data-zillas="{{$row->zillas_id}}"
                                   class="ediItem" data-toggle="modal" data-target="#ediModal"><i class="icon-pencil6 text-success"></i> Edit</a></li>
                            @endcan
                            @can('SubDistrict Delete')
                                <li><a href="{{route('sub-district.destroy', ['sub_district' => $row->id])}}" class="delItem"><i class="icon-bin text-danger"></i> Delete</a></li>
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
                var zillas_id = $(this).data('zillas');

                $('#ediModal form').attr('action', url);
                $('#ediModal [name=name]').val(name);
                $('#ediModal [name=zillas_id]').val(zillas_id).select2();
            });

            $('.district').select2();


            $('.datatable-basic').DataTable({
                columnDefs: [
                    { orderable: false, "targets": [2] }
                ]
            });
        });
    </script>
@endsection