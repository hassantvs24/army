<!-- Main sidebar -->
<div class="sidebar sidebar-main sidebar-fixed">
    <div class="sidebar-content">
        <!-- Main navigation -->
        <div class="sidebar-category sidebar-category-visible">
            <div class="category-content no-padding">
                <ul class="navigation navigation-main navigation-accordion">

                    <!-- Main -->

                    <li class="{{Route::currentRouteName() == 'index' ? 'active':''}}"><a href="{{route('index')}}"><i class="icon-home4"></i> <span>Dashboard</span></a></li>

                    @canany(['Sales Create', 'Sales List', 'Quotations List', 'Draft List'])
                        <li class="navigation-divider"></li>
                            <li class=""><a href="#"><i class=" icon-cart5"></i> <span>Sales</span></a>
                            <ul>
                                @can('Sales Create')
                                    <li class="{{Route::currentRouteName() == 'sales.index' ? 'active':''}}"><a href="{{route('sales.index')}}"><i class="icon-diamond"></i> Add Sales</a></li>
                                @endcan
                                @can('Sales List')
                                    <li class="{{Route::currentRouteName() == 'sales-list.index' ? 'active':''}}"><a href="{{route('sales-list.index')}}"><i class="icon-diamond"></i> Invoice List</a></li>
                                @endcan
                                @can('Quotations List')
                                    <li class="{{Route::currentRouteName() == 'sales.quotation' ? 'active':''}}"><a href="{{route('sales.quotation')}}"><i class="icon-diamond"></i> Quotations List</a></li>
                                @endcan
                                @can('Draft List')
                                    <li class="{{Route::currentRouteName() == 'sales.draft' ? 'active':''}}"><a href="{{route('sales.draft')}}"><i class="icon-diamond"></i> Draft List</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcan

                    @canany(['Customer List', 'Customer Category List', 'Agent List', 'District List', 'SubDistrict List'])
                        <li class=""><a href="#"><i class=" icon-users4"></i> <span>Customers</span></a>
                            <ul>
                                @can('Customer List')
                                    <li class="{{Route::currentRouteName() == 'customer.index' ? 'active':''}}"><a href="{{route('customer.index')}}"><i class="icon-diamond"></i> Customers List</a></li>
                                @endcan
                                @can('Customer Category List')
                                    <li class="{{Route::currentRouteName() == 'customer-category.index' ? 'active':''}}"><a href="{{route('customer-category.index')}}"><i class="icon-diamond"></i> Customers Category</a></li>
                                @endcan
                                @can('Agent List')
                                    <li class="{{Route::currentRouteName() == 'agent.index' ? 'active':''}}"><a href="{{route('agent.index')}}"><i class="icon-diamond"></i> Agent List</a></li>
                                @endcan
                                @can('District List')
                                    <li class="{{Route::currentRouteName() == 'district.index' ? 'active':''}}"><a href="{{route('district.index')}}"><i class="icon-diamond"></i> District</a></li>
                                @endcan
                                @can('SubDistrict List')
                                    <li class="{{Route::currentRouteName() == 'sub-district.index' ? 'active':''}}"><a href="{{route('sub-district.index')}}"><i class="icon-diamond"></i> Sub-district</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcan

                    @canany(['Product List', 'Product Category List', 'Product Units List', 'Product Brand List', 'Product Company List', 'Stock Adjustment List'])
                        <li class="navigation-divider"></li>

                        <li class=""><a href="#"><i class=" icon-truck"></i> <span>Stock</span></a>
                            <ul>
                                @can('Product List')
                                    <li class="{{Route::currentRouteName() == 'products.index' ? 'active':''}}"><a href="{{route('products.index')}}"><i class="icon-diamond"></i> Product List</a></li>
                                @endcan
                                @can('Product Category List')
                                    <li class="{{Route::currentRouteName() == 'product-category.index' ? 'active':''}}"><a href="{{route('product-category.index')}}"><i class="icon-diamond"></i> Product Category</a></li>
                                @endcan
                                @can('Product Units List')
                                    <li class="{{Route::currentRouteName() == 'units.index' ? 'active':''}}"><a href="{{route('units.index')}}"><i class="icon-diamond"></i> Units</a></li>
                                @endcan
                                @can('Product Brand List')
                                    <li class="{{Route::currentRouteName() == 'brand.index' ? 'active':''}}"><a href="{{route('brand.index')}}"><i class="icon-diamond"></i> Brands</a></li>
                                @endcan
                                @can('Product Company List')
                                    <li class="{{Route::currentRouteName() == 'company.index' ? 'active':''}}"><a href="{{route('company.index')}}"><i class="icon-diamond"></i> Company</a></li>
                                @endcan
                                @can('Stock Adjustment List')
                                    <li class="{{Route::currentRouteName() == 'adjustment.index' ? 'active':''}}"><a href="{{route('adjustment.index')}}"><i class="icon-diamond"></i> Stock Adjustment</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcan

                    @canany(['Purchase Create', 'Purchase List', 'Pending List', 'Order List'])
                        <li class="navigation-divider"></li>

                        <li class=""><a href="#"><i class=" icon-cart"></i> <span>Purchase</span></a>
                            <ul>
                                @can('Purchase Create')
                                    <li class="{{Route::currentRouteName() == 'purchase.index' ? 'active':''}}"><a href="{{route('purchase.index')}}"><i class="icon-diamond"></i> Add Purchase</a></li>
                                @endcan
                                @can('Purchase List')
                                    <li class="{{Route::currentRouteName() == 'purchase-list.index' ? 'active':''}}"><a href="{{route('purchase-list.index')}}"><i class="icon-diamond"></i> Purchase List</a></li>
                                @endcan
                                @can('Pending List')
                                    <li class="{{Route::currentRouteName() == 'purchase.pending' ? 'active':''}}"><a href="{{route('purchase.pending')}}"><i class="icon-diamond"></i> Pending List</a></li>
                                @endcan
                                @can('Order List')
                                    <li class="{{Route::currentRouteName() == 'purchase.ordered' ? 'active':''}}"><a href="{{route('purchase.ordered')}}"><i class="icon-diamond"></i> Ordered List</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcan

                    @canany(['Supplier List', 'Supplier Category List'])
                        <li class=""><a href="#"><i class=" icon-user-plus"></i> <span>Suppliers</span></a>
                            <ul>
                                @can('Supplier List')
                                    <li class="{{Route::currentRouteName() == 'supplier.index' ? 'active':''}}"><a href="{{route('supplier.index')}}"><i class="icon-diamond"></i> Suppliers List</a></li>
                                @endcan
                                @can('Supplier Category List')
                                    <li class="{{Route::currentRouteName() == 'supplier-category.index' ? 'active':''}}"><a href="{{route('supplier-category.index')}}"><i class="icon-diamond"></i> Suppliers Category</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcan

                    @canany(['Expense List', 'Expense Category List'])
                        <li class="navigation-divider"></li>

                        <li class=""><a href="#"><i class=" icon-box-remove"></i> <span>Expenses</span></a>
                            <ul>
                                @can('Expense List')
                                    <li class="{{Route::currentRouteName() == 'expenses.index' ? 'active':''}}"><a href="{{route('expenses.index')}}"><i class="icon-diamond"></i> All Expenses</a></li>
                                @endcan
                                @can('Expense Category List')
                                    <li class="{{Route::currentRouteName() == 'expense-category.index' ? 'active':''}}"><a href="{{route('expense-category.index')}}"><i class="icon-diamond"></i> Expense Category</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcan

                    @canany(['Accounts List', 'Cash Flow View', 'Trial Balance View', 'Balance Sheet View'])
                        <li class=""><a href="#"><i class=" icon-calculator3"></i> <span>Payment Account</span></a>
                            <ul>
                                @can('Accounts List')
                                    <li class="{{Route::currentRouteName() == 'accounts.index' ? 'active':''}}"><a href="{{route('accounts.index')}}"><i class="icon-diamond"></i> Accounts List</a></li>
                                @endcan
                                @can('Balance Sheet View')
                                    <li class="{{Route::currentRouteName() == 'accounts.balance' ? 'active':''}}"><a href="{{route('accounts.balance')}}"><i class="icon-diamond"></i> Balance Sheet</a></li>
                                @endcan
                                @can('Trial Balance View')
                                    <li class="{{Route::currentRouteName() == 'accounts.trial' ? 'active':''}}"><a href="{{route('accounts.trial')}}"><i class="icon-diamond"></i> Trial Balance</a></li>
                                @endcan
                                @can('Cash Flow View')
                                    <li class="{{Route::currentRouteName() == 'accounts.cash' ? 'active':''}}"><a href="{{route('accounts.cash')}}"><i class="icon-diamond"></i> Cash Flow</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @canany(['User List', 'Role List'])
                        <li class=""><a href="#"><i class=" icon-users"></i> <span>Users</span></a>
                            <ul>
                                @can('User List')
                                    <li class="{{Route::currentRouteName() == 'users.index' ? 'active':''}}"><a href="{{route('users.index')}}"><i class="icon-diamond"></i> All Users</a></li>
                                @endcan
                                @can('Role List')
                                    <li class="{{Route::currentRouteName() == 'roles.index' ? 'active':''}}"><a href="{{route('roles.index')}}"><i class="icon-diamond"></i> User Roles</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcan

                    @canany(['Business Setup', 'Warehouse List', 'Discount List', 'Vat List', 'Shipment List', 'Zone List'])
                        <li class=""><a href="#"><i class=" icon-hammer-wrench"></i> <span>Settings</span></a>
                            <ul>
                                @can('Business Setup')
                                    <li class="{{Route::currentRouteName() == 'business.show' ? 'active':''}}"><a href="{{route('business.show', ['business' => Auth::user()->business_id])}}"><i class="icon-diamond"></i> Business Setup</a></li>
                                @endcan
                                @can('Warehouse List')
                                    <li class="{{Route::currentRouteName() == 'warehouse.index' ? 'active':''}}"><a href="{{route('warehouse.index')}}"><i class="icon-diamond"></i> Warehouse</a></li>
                                @endcan
                                @can('Discount List')
                                    <li class="{{Route::currentRouteName() == 'discount.index' ? 'active':''}}"><a href="{{route('discount.index')}}"><i class="icon-diamond"></i> Discount</a></li>
                                @endcan
                                @can('Vat List')
                                    <li class="{{Route::currentRouteName() == 'vat-tax.index' ? 'active':''}}"><a href="{{route('vat-tax.index')}}"><i class="icon-diamond"></i> Vat Tax</a></li>
                                @endcan
                                @can('Shipment List')
                                    <li class="{{Route::currentRouteName() == 'shipment.index' ? 'active':''}}"><a href="{{route('shipment.index')}}"><i class="icon-diamond"></i> Shipment</a></li>
                                @endcan
                                @can('Zone List')
                                    <li class="{{Route::currentRouteName() == 'zone.index' ? 'active':''}}"><a href="{{route('zone.index')}}"><i class="icon-diamond"></i> Zone</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcan

                    @can('Reports Generate')
                        <li class=""><a href="#"><i class=" icon-chart"></i> <span>Reports</span></a>
                            <ul>
                                <li class="{{Route::currentRouteName() == 'reports.profit-loss' ? 'active':''}}"><a href="{{route('reports.profit-loss')}}"><i class="icon-diamond"></i> Profit/Loss Reports</a></li>
                                <li class="{{Route::currentRouteName() == 'reports.expense' ? 'active':''}}"><a href="{{route('reports.expense')}}"><i class="icon-diamond"></i> Expense Reports</a></li>
                                <li class="{{Route::currentRouteName() == 'reports.sales' ? 'active':''}}"><a href="{{route('reports.sales')}}"><i class="icon-diamond"></i> Sales Reports</a></li>
                                <li class="{{Route::currentRouteName() == 'reports.purchase' ? 'active':''}}"><a href="{{route('reports.purchase')}}"><i class="icon-diamond"></i> Purchase Reports</a></li>
                                <li class="{{Route::currentRouteName() == 'reports.stock' ? 'active':''}}"><a href="{{route('reports.stock')}}"><i class="icon-diamond"></i> Stock Reports</a></li>
                                <li class="{{Route::currentRouteName() == 'reports.customer' ? 'active':''}}"><a href="{{route('reports.customer')}}"><i class="icon-diamond"></i> Customer Reports</a></li>
                                <!--<li class="{{Route::currentRouteName() == 'reports.supplier' ? 'active':''}}"><a href="{{route('reports.supplier')}}"><i class="icon-diamond"></i> Supplier Reports</a></li>-->
                                <li class="{{Route::currentRouteName() == 'reports.accounts' ? 'active':''}}"><a href="{{route('reports.accounts')}}"><i class="icon-diamond"></i> Accounts Reports</a></li>
                            </ul>
                        </li>
                    @endcan

                    <li class="navigation-divider"></li>

                </ul>
            </div>
        </div>
        <!-- /main navigation -->
    </div>
</div>
<!-- /main sidebar -->