@extends('layouts.master')
@extends('users.box.roles')

@section('title')
    User Roles
@endsection
@section('content')


    <x-site name="User Roles">

        <x-slot name="header">
            @can('Role Create')
            <button id="headerBtn" type="button" class="btn btn-primary heading-btn btn-labeled btn-labeled-left" data-toggle="modal" data-target="#myModal"><b><i class="icon-add-to-list"></i></b> Add New User Role</button>
            @endcan
        </x-slot>

        <table class="table table-striped table-condensed table-hover datatable-basic">
            <thead>
            <tr>
                <th class="p-th">Role Name</th>
                <th class="p-th">Number Of Permission</th>
                <th class="text-right"><i class="icon-more"></i></th>
            </tr>
            </thead>
            <tbody>
            @foreach($table as $row)
                <tr>
                    <td class="p-td">{{$row->name}}</td>
                    <td class="p-td">{{$row->getAllPermissions()->count()}}</td>
                    <td class="text-right p-td">
                        @php
                            $data = [];
                            $old_permission = $row->getAllPermissions();
                            foreach ($old_permission as $permit){
                                $data[] = $permit->id;
                            }
                        @endphp
                        @if($row->name != 'Super Admin')
                            <x-actions>
                                @can('Role Permission')
                                    <li><a href="{{route('role.permission', ['role' => $row->id])}}" class="permissionEdit" data-permission="{{json_encode($data)}}" data-toggle="modal" data-target="#permissionModal"><i class="icon-magic-wand text-warning"></i> Add Permission</a></li>
                                @endcan
                                @can('Role Edit')
                                    <li><a href="{{route('roles.update', ['role' => $row->id])}}"
                                           data-name="{{$row->name}}"
                                           class="ediItem" data-toggle="modal" data-target="#ediModal"><i class="icon-pencil6 text-success"></i> Edit</a></li>
                                @endcan
                                @can('Role Delete')
                                    <li><a href="{{route('roles.destroy', ['role' => $row->id])}}" class="delItem"><i class="icon-bin text-danger"></i> Delete</a></li>
                                @endcan
                            </x-actions>
                        @endif
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

                $('#ediModal form').attr('action', url);
                $('#ediModal [name=name]').val(name);
            });

            $('.permissionEdit').click(function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                var permission = $(this).data('permission');
                $('#permissionModal form').attr('action', url);
                $('#permissionModal input:checkbox').prop('checked',false);

                $.each(permission, function( index, value ) {
                   // alert( index + ": " + value );
                    $('#permissionModal .val_'+value+':checkbox').prop('checked',true);
                });

            });

            $('.selectAll').click(function () {
                $('#permissionModal input:checkbox').prop('checked',true);
            });

            $('.unSelectAll').click(function () {
                $('#permissionModal input:checkbox').prop('checked',false);
            });


            $('.datatable-basic').DataTable({
                columnDefs: [
                    { orderable: false, "targets": [2] }
                ]
            });
        });



    </script>
@endsection