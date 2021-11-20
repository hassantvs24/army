@section('box')

    <x-modal id="myModal" action="{{route('products.store')}}" size="modal-full" title="Add New Product" icon="grid5">
        <div class="row">
            <div class="col-md-6">
                <x-select class="product_type" name="product_type" label="Product Type" required="required" >
                    <option value="Main">Main</option>
                    <option value="Other">Other</option>
                </x-select>
                <x-input name="sku" label="Serial Number" value="{{mt_rand()}}" required="required" />
                <x-input name="name" label="Product Name" required="required" />
                <x-select class="category" name="product_categories_id" label="Product Category" required="required" >
                    @foreach($category as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
                </x-select>
                <x-select class="brands" name="brands_id" label="Product Brand">
                    @foreach($brand as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
                </x-select>
                <x-select class="companies" name="companies_id" label="Product Companies">
                    @foreach($company as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
                </x-select>
            </div>
            <div class="col-md-6">
                <x-select class="units" name="units_id" label="Product Units" required="required">
                    @foreach($units as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
                </x-select>
                <x-input name="sell_price" type="number" label="Sales Price" rest="step=any min=0"  value="0" required="required" />
                <x-input name="purchase_price" type="number" label="Purchase Price" rest="step=any min=0"  value="0" required="required" />
                <x-input name="stock" type="number" label="Opening Stock" rest="step=any min=0"  value="0" required="required" />
                <x-input name="alert_quantity" type="number" label="Alert Quantity" rest="step=any min=0"  value="0" required="required" />
                <x-input name="description" label="Product Description" />

            </div>
        </div>

    </x-modal>


    <x-modal id="ediModal" action="#" title="Edit Product" size="modal-full" bg="success" icon="pencil6">
        @method('PUT')

        <div class="row">
            <div class="col-md-6">
                <x-select name="product_type" label="Product Type" required="required" >
                    <option value="Main">Main</option>
                    <option value="Other">Other</option>
                </x-select>
                <x-input name="sku" label="Serial Number" required="required" />
                <x-input name="name" label="Product Name" required="required" />
                <x-select name="product_categories_id" label="Product Category" required="required" >
                    @foreach($category as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
                </x-select>
                <x-select name="brands_id" label="Product Brand">
                    @foreach($brand as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
                </x-select>
                <x-select name="companies_id" label="Product Companies">
                    @foreach($company as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
                </x-select>
            </div>
            <div class="col-md-6">
                <x-select name="units_id" label="Product Units" required="required">
                    @foreach($units as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
                </x-select>
                <x-input name="sell_price" type="number" label="Sales Price" rest="step=any min=0"  value="0" required="required" />
                <x-input name="purchase_price" type="number" label="Purchase Price" rest="step=any min=0"  value="0" required="required" />
                <x-input name="stock" type="number" label="Opening Stock" rest="step=any min=0"  value="0" required="required" />
                <x-input name="alert_quantity" type="number" label="Alert Quantity" rest="step=any min=0"  value="0" required="required" />
                <x-input name="description" label="Product Description" />

            </div>
        </div>

    </x-modal>

@endsection
