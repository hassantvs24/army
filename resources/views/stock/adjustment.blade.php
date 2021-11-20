@extends('layouts.master')
@extends('stock.box.adjustment')

@section('title')
    Stock Adjustment
@endsection
@section('content')


    <x-site name="Stock Adjustment" body="New Stock Adjustment">
        <x-slot name="header">
            @can('Stock Adjustment Create')
                <button id="headerBtn" type="button" class="btn btn-primary heading-btn btn-labeled btn-labeled-left" data-toggle="modal" data-target="#myModal"><b><i class="icon-add-to-list"></i></b> Add New Adjustment</button>
            @endcan
        </x-slot>

        <table class="table table-striped table-condensed table-hover datatable-basic">
            <thead>
            <tr>
                <th class="p-th">Date</th>
                <th class="p-th">S/N</th>
                <th class="p-th">Recover Amount</th>
                <th class="p-th">Description</th>
                <th class="p-th">Warehouse</th>
                <th class="p-th">Items</th>
                <th class="text-right"><i class="icon-more"></i></th>
            </tr>
            </thead>
            <tbody>
            @foreach($table as $row)
                <tr>
                    <td class="p-td">{{pub_date($row->created_at)}}</td>
                    <td class="p-td">{{$row->code}}</td>
                    <td class="p-td">{{$row->recover_amount}}</td>
                    <td class="p-td">{{$row->description}}</td>
                    <td class="p-td">{{$row->warehouse['name']}}</td>
                    @php
                        $items = $row->stockAdjustmentItems()->count();
                    @endphp
                    <td class="p-td">{{$items}}</td>
                    <td class="text-right p-td">
                        <x-actions>
                            @can('Stock Adjustment Edit')
                                <li><a data-items="{{route('get_item', ['id' => $row->id])}}" href="{{route('adjustment.update', ['adjustment' => $row->id])}}"
                                   data-code="{{$row->code}}"
                                   data-cdate="{{pub_date($row->created_at)}}"
                                   data-amount="{{$row->recover_amount}}"
                                   data-description="{{$row->description}}"
                                   data-warehouse="{{$row->warehouses_id}}"
                                   class="ediItem" data-toggle="modal" data-target="#ediModal"><i class="icon-pencil6 text-success"></i> Edit</a></li>
                            @endcan
                            @can('Stock Adjustment Delete')
                                <li><a href="{{route('adjustment.destroy', ['adjustment' => $row->id])}}" class="delItem"><i class="icon-bin text-danger"></i> Delete</a></li>
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

            var all_items = [];

            $('#headerBtn').click(function () {
                all_items = [];
                render_item();
            });

            $('.ediItem').click(function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                var code = $(this).data('code');
                var recover_amount = $(this).data('amount');
                var description = $(this).data('description');
                var warehouses_id = $(this).data('warehouse');
                var created_at = $(this).data('cdate');

                var item_url = $(this).data('items');

                $('#ediModal form').attr('action', url);
                $('#ediModal [name=code]').val(code);
                $('#ediModal [name=recover_amount]').val(recover_amount);
                $('#ediModal [name=description]').val(description);
                $('#ediModal [name=warehouses_id]').val(warehouses_id).select2();
                $('#ediModal [name=created_at]').val(created_at);

                all_items = [];

                $.getJSON( item_url, function( data ) {
                    $.each(data, function( i, value ) {
                        all_items.push({
                            id: value.id,
                            sku: value.sku,
                            name:value.name,
                            qty: value.qty,
                            action: value.action
                        });
                    });

                    render_item();
                });

            });

            $('.warehouses, .products').select2();

            $('.products').on('change', function () {
                var products = $(this).val();
                if(products != ''){
                    var productArr = products.split(' -x- ');
                    const single_item = all_items.filter(all_item => all_item.id == productArr[0]);
                    if(single_item.length === 0){
                        all_items.unshift({
                            id: productArr[0],
                            sku: productArr[1],
                            name: productArr[2],
                            qty: 1,
                            action: 'OUT'
                        });
                    }

                    render_item();
                }

            });

            function render_item() {
                var tbl_item = '';
                $.each(all_items, function( index, value ) {

                    tbl_item += `<tr>
                        <td>${value.sku}</td>
                        <td>${value.name}</td>
                        <td><input name="qty[${value.id}]" value="${value.qty}" class="form-control qtyItem" data-id="${value.id}" type="number" step="any" min="0.01" placeholder="Quantity" /></td>
                        <td>
                            <select name="action[${value.id}]" class="form-control actionItem" data-id="${value.id}">
                                <option value="OUT" ${value.action == 'OUT' ? 'Selected':''}>OUT</option>
                                <option value="IN" ${value.action == 'IN' ? 'Selected':''}>IN</option>
                            </select>
                        </td>
                        <td class="text-right"><button type="button" class="btn btn-danger btn-xs delete_item" value="${value.id}"><i class="icon-bin"></i></button></td>
                    </tr>`;
                });
                $('.item_list').html(tbl_item);
                del_item();
                update_item();
                disible_submit_btn();
            }

            function disible_submit_btn() {
                if(all_items.length > 0){
                    $('#myModal [type=submit]').prop('disabled', false);
                    $('#ediModal [type=submit]').prop('disabled', false);
                }else{
                    $('#myModal [type=submit]').prop('disabled', true);
                    $('#ediModal [type=submit]').prop('disabled', true);
                }
            }

            function del_item(){
                $('.delete_item').click(function () {
                    var id = $(this).val();
                    all_items = all_items.filter(all_item => all_item.id != id);
                    render_item();
                });
            }

            function update_item(){
                $('.qtyItem').on('change', function () {
                    var id = $(this).data('id');
                    var cu_val = $(this).val();
                    var objIndex = all_items.findIndex((obj => obj.id == id));
                    all_items[objIndex].qty = cu_val;
                });

                $('.actionItem').on('change', function () {
                    var id = $(this).data('id');
                    var cu_val = $(this).val();
                    var objIndex = all_items.findIndex((obj => obj.id == id));
                    all_items[objIndex].action = cu_val;
                });
            }



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