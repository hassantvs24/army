@extends('layouts.master')
@extends('users.box.users')

@section('title')
    User List
@endsection

@section('content')


    <x-site name="User List" body="Add New User">

        <x-slot name="header">
            @can('User Create')
                <button id="headerBtn" type="button" class="btn btn-primary heading-btn btn-labeled btn-labeled-left" data-toggle="modal" data-target="#myModal"><b><i class="icon-add-to-list"></i></b> Add New User</button>
            @endcan
        </x-slot>

        <table class="table table-striped table-condensed table-hover datatable-basic">
            <thead>
            <tr>
                <th class="p-th">Name</th>
                <th class="p-th">Email</th>
                <th class="p-th">User Roles</th>
                <th class="p-th">Default Warehouse</th>
                <th class="p-th">Default Account Book</th>
                <th class="text-right"><i class="icon-more"></i></th>
            </tr>
            </thead>
            <tbody>
            @foreach($table as $row)
                @php
                    $role = $row->getRoleNames()->first();
                    if($role != null){
                        $role_id = $row->roles()->first()->id;
                    }

                @endphp
                <tr>
                    <td class="p-td">{{$row->name}}</td>
                    <td class="p-td">{{$row->email}}</td>
                    <td class="p-td">{{$role ?? ''}}</td>
                    <td class="p-td">{{$row->warehouse['name']}}</td>
                    <td class="p-td">{{$row->accountBook['name']}}</td>
                    <td class="text-right p-td">
                        <x-actions>
                            @can('User Edit')
                                <li><a href="{{route('users.update', ['user' => $row->id])}}"
                                   data-role="{{$role_id ?? ''}}"
                                   data-name="{{$row->name}}"
                                   data-email="{{$row->email}}"
                                   data-warehouses="{{$row->warehouses_id}}"
                                   data-accounts="{{$row->account_books_id}}"
                                   class="ediItem" data-toggle="modal" data-target="#ediModal"><i class="icon-pencil6 text-success"></i> Edit</a></li>
                            @endcan
                            @can('User Delete')
                                <li><a href="{{route('users.destroy', ['user' => $row->id])}}" class="delItem"><i class="icon-bin text-danger"></i> Delete</a></li>
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
                var email = $(this).data('email');
                var warehouses_id = $(this).data('warehouses');
                var account_books_id = $(this).data('accounts');
                var role_id = $(this).data('role');

                $('#ediModal form').attr('action', url);
                $('#ediModal [name=name]').val(name);
                $('#ediModal [name=email]').val(email);
                $('#ediModal [name=warehouses_id]').val(warehouses_id).select2();
                $('#ediModal [name=account_books_id]').val(account_books_id).select2();
                $('#ediModal [name=role_id]').val(role_id).select2();
            });

            $('.warehouses, .accounts, .roles').select2();

            $('.datatable-basic').DataTable({
                columnDefs: [
                    { orderable: false, "targets": [4] }
                ]
            });
        });
    </script>
@endsection