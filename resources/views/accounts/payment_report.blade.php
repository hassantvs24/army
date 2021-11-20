@extends('layouts.master')
@extends('box.welcome')

@section('title')
    Payment Account Report
@endsection
@section('content')

    <x-page name="Welcome" body="Add Elements">

        <table class="table table-striped table-condensed table-hover datatable-basic">
            <thead>
            <tr>
                <th class="p-th">Name</th>
                <th class="p-th">Contact</th>
                <th class="text-right"><i class="icon-more"></i></th>
            </tr>
            </thead>
            <tbody>
            @foreach($table as $row)
                <tr>
                    <td class="p-td">{{$row->name}}</td>
                    <td class="p-td">{{$row->contact}}</td>
                    <td class="text-right p-td">
                        <x-actions>
                            <li><a href="{{route('warehouse.update', ['warehouse' => $row->id])}}"
                                   data-name="{{$row->name}}"
                                   data-contact="{{$row->contact}}"
                                   class="ediItem" data-toggle="modal" data-target="#ediModal"><i class="icon-pencil6 text-success"></i> Edit</a></li>
                            <li><a href="{{route('warehouse.destroy', ['warehouse' => $row->id])}}" class="delItem"><i class="icon-bin text-danger"></i> Delete</a></li>
                        </x-actions>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </x-page>


@endsection

@section('script')
    <script type="text/javascript">
        $(function () {
            $('.ediItem').click(function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                var name = $(this).data('name');
                var contact = $(this).data('contact');

                $('#ediModal form').attr('action', url);
                $('#ediModal [name=name]').val(name);
                $('#ediModal [name=contact]').val(contact);
            });


            $('.datatable-basic').DataTable({
                columnDefs: [
                    { orderable: false, "targets": [3] }
                ]
            });
        });
    </script>
@endsection