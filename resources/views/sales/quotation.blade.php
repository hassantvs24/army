@extends('layouts.master')

@section('title')
    Sales Quotation List
@endsection
@section('content')


    <x-page name="Sales Quotation List">

        <table class="table table-striped table-condensed table-hover datatable-basic">
            <thead>
            <tr>
                <th class="p-th">Date</th>
                <th class="p-th">S/N</th>
                <th class="p-th">Name</th>
                <th class="p-th">Contact</th>
                <th class="p-th">Status</th>
                <th class="p-th">Total</th>
                <th class="p-th">Paid</th>
                <th class="text-right"><i class="icon-more"></i></th>
            </tr>
            </thead>
            <tbody>
            @foreach($table as $row)
                <tr>
                    <td class="p-td">{{pub_date($row->created_at)}}</td>
                    <td class="p-td">{{$row->code}}</td>
                    <td class="p-td">{{$row->name}}</td>
                    <td class="p-td">{{$row->contact}}</td>
                    <td class="p-td">{{$row->status}}</td>
                    <td class="p-td">{{money_c($row->invoice_sub_total())}}</td>
                    <td class="p-td">{{money_c($row->invoice_paid())}}</td>
                    <td class="text-right p-td">
                        <x-actions>
                            @can('Sales Edit')
                                <li><a  href="{{route('sales.edit', ['sale' => $row->id])}}"><i class="icon-pencil6 text-success"></i> Edit</a></li>
                            @endcan
                            @can('Sales Delete')
                                <li><a href="{{route('sales.destroy', ['sale' => $row->id])}}" class="delItem"><i class="icon-bin text-danger"></i> Delete</a></li>
                            @endcan
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
                    { orderable: false, "targets": [7] }
                ]
            });
        });
    </script>
@endsection