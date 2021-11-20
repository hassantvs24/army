@extends('layouts.master')
@extends('expenses.box.expenses')

@section('title')
    Expenses
@endsection

@section('content')

    <x-site name="Expenses" body="Create New Expenses">

        <x-slot name="header">
            @can('Expense Create')
                <button id="headerBtn" type="button" class="btn btn-primary heading-btn btn-labeled btn-labeled-left" data-toggle="modal" data-target="#myModal"><b><i class="icon-add-to-list"></i></b> Add New Expenses</button>
            @endcan
        </x-slot>

        <table class="table table-striped table-condensed table-hover datatable-basic">
            <thead>
            <tr>
                <th class="p-th">Date</th>
                <th class="p-th">S/N</th>
                <th class="p-th">Expense Category</th>
                <th class="p-th">Description</th>
                <th class="p-th">Warehouse</th>
                <th class="p-th">Amount</th>
                <th class="text-right"><i class="icon-more"></i></th>
            </tr>
            </thead>
            <tbody>
            @foreach($table as $row)
                <tr>
                    <td class="p-td">{{pub_date($row->created_at)}}</td>
                    <td class="p-td">{{$row->code}}</td>
                    <td class="p-td">{{$row->expenseCategory['name']}}</td>
                    <td class="p-td">{{$row->description}}</td>
                    <td class="p-td">{{$row->warehouse['name']}}</td>
                    <td class="p-td">{{money_c($row->amount)}}</td>
                    <td class="text-right p-td">
                        <x-actions>
                            @can('Expense Edit')
                                <li><a href="{{route('expenses.update', ['expense' => $row->id])}}"
                                   data-cdate="{{pub_date($row->created_at)}}"
                                   data-warehouses="{{$row->warehouses_id}}"
                                   data-code="{{$row->code}}"
                                   data-categopry="{{$row->expense_categories_id}}"
                                   data-description="{{$row->description}}"
                                   data-amount="{{$row->amount}}"
                                   class="ediItem" data-toggle="modal" data-target="#ediModal"><i class="icon-pencil6 text-success"></i> Edit</a></li>
                            @endcan
                            @can('Expense Delete')
                                <li><a href="{{route('expenses.destroy', ['expense' => $row->id])}}" class="delItem"><i class="icon-bin text-danger"></i> Delete</a></li>
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
                var created_at = $(this).data('cdate');
                var expense_categories_id = $(this).data('categopry');
                var description = $(this).data('description');
                var amount = $(this).data('amount');
                var code = $(this).data('code');
                var warehouses_id = $(this).data('warehouses');

                $('#ediModal form').attr('action', url);
                $('#ediModal [name=code]').val(code);
                $('#ediModal [name=amount]').val(amount);
                $('#ediModal [name=description]').val(description);
                $('#ediModal [name=warehouses_id]').val(warehouses_id).select2();
                $('#ediModal [name=expense_categories_id]').val(expense_categories_id).select2();
                $('#ediModal [name=created_at]').val(created_at);

            });

            $('.category, .warehouses').select2();


            $('.datatable-basic').DataTable({
                columnDefs: [
                    { orderable: false, "targets": [6] }
                ]
            });

            $('.date_pic').daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });

        });
    </script>
@endsection