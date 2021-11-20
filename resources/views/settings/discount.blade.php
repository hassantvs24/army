@extends('layouts.master')
@extends('settings.box.discount')

@section('title')
    Discount
@endsection
@section('content')

    <x-site name="Discount Setup" body="Add New Discount">
        <x-slot name="header">
            @can('Discount Create')
                <button id="headerBtn" type="button" class="btn btn-primary heading-btn btn-labeled btn-labeled-left" data-toggle="modal" data-target="#myModal"><b><i class="icon-add-to-list"></i></b> Add New Discount</button>
            @endcan
        </x-slot>

        <table class="table table-striped table-condensed table-hover datatable-basic">
            <thead>
            <tr>
                <th class="p-th">Name</th>
                <th class="p-th">Discount Type</th>
                <th class="p-th">Amount</th>
                <th class="text-right"><i class="icon-more"></i></th>
            </tr>
            </thead>
            <tbody>
            @foreach($table as $row)
                <tr>
                    <td class="p-td">{{$row->name}}</td>
                    <td class="p-td">{{$row->discount_type}}</td>
                    <td class="p-td">{{$row->amount}}</td>
                    <td class="text-right p-td">
                        <x-actions>
                            @can('Discount Edit')
                                <li><a href="{{route('discount.update', ['discount' => $row->id])}}"
                                   data-name="{{$row->name}}"
                                   data-dstype="{{$row->discount_type}}"
                                   data-amount="{{$row->amount}}"
                                   class="ediItem" data-toggle="modal" data-target="#ediModal"><i class="icon-pencil6 text-success"></i> Edit</a></li>
                            @endcan
                            @can('Discount Delete')
                                <li><a href="{{route('discount.destroy', ['discount' => $row->id])}}" class="delItem"><i class="icon-bin text-danger"></i> Delete</a></li>
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
                var discount_type = $(this).data('dstype');
                var amount = $(this).data('amount');

                $('#ediModal form').attr('action', url);
                $('#ediModal [name=name]').val(name);
                $('#ediModal [name=discount_type]').val(discount_type);
                $('#ediModal [name=amount]').val(amount);

                $('.ediSelect2').select2();

            });

            $('.select2').select2();


            $('.datatable-basic').DataTable({
                columnDefs: [
                    { orderable: false, "targets": [3] }
                ]
            });
        });

    </script>
@endsection