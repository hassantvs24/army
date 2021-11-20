@extends('layouts.master')
@extends('supplier.box.supplier')

@section('title')
    Supplier
@endsection

@section('content')


    <x-site name="Supplier List">

        <x-slot name="header">
            @can('Supplier Create')
                <button id="headerBtn" type="button" class="btn btn-primary heading-btn btn-labeled btn-labeled-left" data-toggle="modal" data-target="#myModal"><b><i class="icon-add-to-list"></i></b> Add New Supplier</button>
            @endcan
        </x-slot>

        <table class="table table-striped table-condensed table-hover datatable-basic">
            <thead>
            <tr>
                <th class="p-th">S/N</th>
                <th class="p-th">Name</th>
                <th class="p-th">Contact</th>
                <th class="p-th">Email</th>
                <th class="p-th">Address</th>
                <th class="p-th">Phone</th>
                <th class="p-th">Contact2</th>
                <th class="p-th">Category</th>
                {{--<th class="p-th">Warehouse</th>--}}
                <th class="p-th">Due</th>
                <th class="text-right"><i class="icon-more"></i></th>
            </tr>
            </thead>
            <tbody>
            @foreach($table as $row)
                <tr>
                    <td class="p-td">{{$row->code}}</td>
                    <td class="p-td">{{$row->name}}</td>
                    <td class="p-td">{{$row->contact}}</td>
                    <td class="p-td">{{$row->email}}</td>
                    <td class="p-td">{{$row->address}}</td>
                    <td class="p-td">{{$row->phone}}</td>
                    <td class="p-td">{{$row->alternate_contact}}</td>
                    <td class="p-td">{{$row->supplierCategory['name']}}</td>
                   {{-- <td class="p-td">{{$row->warehouse['name']}}</td> --}}
                    <td class="p-td">{{$row->dueBalance()}}</td>
                    <td class="text-right p-td">
                        <x-actions>
                            @can('Supplier Edit')
                                <li><a href="#{{route('supplier.update', ['list' => $row->id])}}"
                                   data-category="{{$row->supplier_categories_id}}"
                                   data-warehouses="{{$row->warehouses_id}}"
                                   data-name="{{$row->name}}"
                                   data-code="{{$row->code}}"
                                   data-contact="{{$row->contact}}"
                                   data-email="{{$row->email}}"
                                   data-address="{{$row->address}}"
                                   data-phone="{{$row->phone}}"
                                   data-contacttwo="{{$row->alternate_contact}}"
                                   data-description="{{$row->description}}"
                                   class="ediItem" data-toggle="modal" data-target="#ediModal"><i class="icon-pencil6 text-success"></i> Edit</a></li>
                            @endcan
                            @can('Supplier Transaction')
                                <li><a href="{{route('supplier.show', ['list' => $row->id])}}"><i class="icon-shuffle text-primary"></i> Payment Transaction</a></li>
                            @endcan
                            @can('Supplier Payment')
                            @if($row->dueBalance() != 0)
                                <li><a href="{{route('supplier.payment', ['id' => $row->id])}}" class="payment" data-balance="{{$row->dueBalance()}}" data-toggle="modal" data-target="#payModal"><i class="icon-wallet text-purple"></i> Due Payment</a></li>
                            @endif
                            @endcan
                            @can('Supplier Delete')
                                <li><a href="{{route('supplier.destroy', ['list' => $row->id])}}" class="delItem"><i class="icon-bin text-danger"></i> Delete</a></li>
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
        var balance = 0;

        $(function () {

            $('.warehouse').val("{{auth()->user()->warehouses_id}}").select2();
            $('.accounts').val("{{auth()->user()->account_books_id}}").select2();

            $('.category, .payment_method').select2();

            $('.ediItem').click(function (e) {
                e.preventDefault();
                var url = $(this).attr('href').substr(1);
                var name = $(this).data('name');
                var code = $(this).data('code');
                var contact = $(this).data('contact');
                var email = $(this).data('email');
                var address = $(this).data('address');
                var phone = $(this).data('phone');
                var alternate_contact = $(this).data('contacttwo');
                var description = $(this).data('description');
                var supplier_categories_id = $(this).data('category');
                var warehouses_id = $(this).data('warehouses');


                $('#ediModal form').attr('action', url);
                $('#ediModal [name=name]').val(name);
                $('#ediModal [name=warehouses_id]').val(warehouses_id).select2();
                $('#ediModal [name=supplier_categories_id]').val(supplier_categories_id).select2();
                $('#ediModal [name=code]').val(code);
                $('#ediModal [name=contact]').val(contact);
                $('#ediModal [name=email]').val(email);
                $('#ediModal [name=address]').val(address);
                $('#ediModal [name=phone]').val(phone);
                $('#ediModal [name=description]').val(description);
                $('#ediModal [name=alternate_contact]').val(alternate_contact);
            });

            $('.payment').click(function (e) {
                e.preventDefault();

                balance = $(this).data('balance');

                $('#payModal [name=amount]').val(0);

                $('.cheque_number').hide();
                $('.bank_account_no').hide();
                $('.transaction_no').hide();

                var url = $(this).attr('href');
                $('#payModal form').attr('action', url);

            });


            $('.payment_method').change(function () {
                var methods = $(this).val();
                switch(methods) {
                    case "Cheque":
                        $('.cheque_number').show();
                        $('.bank_account_no').hide();
                        $('.transaction_no').hide();
                        break;
                    case "Bank Transfer":
                        $('.cheque_number').hide();
                        $('.bank_account_no').show();
                        $('.transaction_no').hide();
                        break;
                    case "Other":
                        $('.cheque_number').hide();
                        $('.bank_account_no').hide();
                        $('.transaction_no').show();
                        break;
                    case "Customer Account":
                        $('.cheque_number').hide();
                        $('.bank_account_no').hide();
                        $('.transaction_no').hide();
                        break;
                    default:
                        $('.cheque_number').hide();
                        $('.bank_account_no').hide();
                        $('.transaction_no').hide();
                }
            });


            $('.date_pic').daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });

            $('.datatable-basic').DataTable({
                columnDefs: [
                    { orderable: false, "targets": [9] }
                ]
            });
        });

    </script>
@endsection