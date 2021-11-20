@extends('layouts.master')

@section('title')
    Expense Report
@endsection
@section('content')
    <div class="row">
        <div class="col-md-5">
            <x-rpnl name="Expanse Report" action="{{route('reports.expense-report')}}">
                <x-dinput class="date_pic" name="date_range" label="Date Range" required="required">
                    <x-slot name="addon"><i class="icon-calendar2"></i></x-slot>
                </x-dinput>
                <x-dselect label="Expense Category" class="category" name="expense_categories_id" required="">
                    <option value="">Select Expanse Category (Optional)</option>
                    @foreach($table as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
                </x-dselect>
            </x-rpnl>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        // if(performance.navigation.type === 2) {//Refresh back btn history
        //     location.reload();
        // }

        $(function () {
            $('.category').select2();

            $('.date_pic').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });
        });

    </script>
@endsection