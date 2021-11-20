@extends('layouts.master')
@extends('settings.box.warehouse')
@section('title')
    Warehouse
@endsection
@section('content')

    <x-site name="Warehouse Setup">
        <x-slot name="header">
            @can('Warehouse Create')
                <button id="headerBtn" type="button" class="btn btn-primary heading-btn btn-labeled btn-labeled-left" data-toggle="modal" data-target="#myModal"><b><i class="icon-add-to-list"></i></b> Add New Warehouse</button>
            @endcan
        </x-slot>

        <table class="table table-striped table-condensed table-hover datatable-basic">
            <thead>
                <tr>
                    <th class="p-th">Logo</th>
                    <th class="p-th">Name</th>
                    <th class="p-th">Contact</th>
                    <th class="p-th">Email</th>
                    <th class="p-th">Address</th>
                    <th class="p-th">Phone</th>
                    <th class="text-right"><i class="icon-more"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach($table as $row)
                    <tr>
                        <td class="p-td"><img src="{{asset('public/logo_'.$row->getRawOriginal('logo'))}}" class="img-responsive img-rounded" alt="logo{{$row->id}}"></td>
                        <td class="p-td">{{$row->name}}</td>
                        <td class="p-td">{{$row->contact}}</td>
                        <td class="p-td">{{$row->email}}</td>
                        <td class="p-td">{{$row->address}}</td>
                        <td class="p-td">{{$row->phone}}</td>
                        <td class="text-right p-td">
                            <x-actions>
                                @can('Warehouse Edit')
                                    <li><a href="{{route('warehouse.update', ['warehouse' => $row->id])}}"
                                       data-name="{{$row->name}}"
                                       data-contact="{{$row->contact}}"
                                       data-email="{{$row->email}}"
                                       data-address="{{$row->address}}"
                                       data-phone="{{$row->phone}}"
                                       data-logo="{{$row->logo}}"
                                       class="ediItem" data-toggle="modal" data-target="#ediModal"><i class="icon-pencil6 text-success"></i> Edit</a></li>
                                @endcan
                                @can('Warehouse Delete')
                                    <li><a href="{{route('warehouse.destroy', ['warehouse' => $row->id])}}" class="delItem"><i class="icon-bin text-danger"></i> Delete</a></li>
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
                var contact = $(this).data('contact');
                var email = $(this).data('email');
                var address = $(this).data('address');
                var phone = $(this).data('phone');
                var logo = $(this).data('logo');

                $('#ediModal form').attr('action', url);
                $('#ediModal [name=name]').val(name);
                $('#ediModal [name=contact]').val(contact);
                $('#ediModal [name=email]').val(email);
                $('#ediModal [name=address]').val(address);
                $('#ediModal [name=phone]').val(phone);
                $('#ediModal .imgLogo').attr('src',logo);

            });


            $('.datatable-basic').DataTable({
                columnDefs: [
                    { orderable: false, "targets": [0, 6] }
                ]
            });
        });

    </script>
@endsection