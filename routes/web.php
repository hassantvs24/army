<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => 'auth'], function () {

    Route::middleware(['activation'])->group(function () {

        Route::get('/', 'Dashboard\DashboardController@index')->name('index');
        Route::get('/api/graph', 'Dashboard\DashboardController@fixed_data')->name('api.graph');
        Route::get('/api/info', 'Dashboard\DashboardController@info_data')->name('api.info');

        Route::get('/purchase/list',  'Purchase\PurchaseListController@index')->name('purchase-list.index');
        Route::get('/purchase/pending',  'Purchase\PurchaseListController@pending')->name('purchase.pending');
        Route::get('/purchase/ordered',  'Purchase\PurchaseListController@ordered')->name('purchase.ordered');
        Route::resource('/purchase',  'Purchase\PurchaseController')->except(['create']);

        Route::get('/sales/list',  'Sales\SalesListController@index')->name('sales-list.index');
        Route::get('/sales/quotation',  'Sales\SalesListController@quotation')->name('sales.quotation');
        Route::get('/sales/draft',  'Sales\SalesListController@draft')->name('sales.draft');
        Route::resource('/sales',  'Sales\SalesController')->except(['create']);

        Route::get('/api/customer/info',  'Customer\CustomerController@get_cr_bl')->name('customer_bl.api');
        Route::get('/api/customer',  'Customer\CustomerController@customer_api')->name('customer.api');
        Route::get('/api/customer-table',  'Customer\CustomerController@customer_table_api')->name('customer-table.api');
        Route::put('/customer/payment/{id}',  'Customer\CustomerController@due_payment')->name('customer.payment');
        Route::resource('/customer/list',  'Customer\CustomerController',['names' => 'customer'])->except(['create', 'edit']);

        Route::resource('/customer/agent',  'Customer\AgentController')->except(['create', 'show', 'edit']);
        Route::resource('/customer/district',  'Customer\ZillaController')->except(['create', 'show', 'edit']);
        Route::resource('/customer/sub-district',  'Customer\UpaZillaController')->except(['create', 'show', 'edit']);
        Route::resource('/customer/agent',  'Customer\AgentController')->except(['create', 'show', 'edit']);
        Route::resource('/customer/category',  'Customer\CustomerCategoryController',['names' => 'customer-category'])->except(['create', 'show', 'edit']);

        Route::get('/api/product',  'Stock\ProductController@product_api')->name('product.api');
        Route::get('/stock/transaction/{id}',  'Stock\ProductController@transaction')->name('stock.transaction');
        Route::resource('/stock/products',  'Stock\ProductController')->except(['create', 'show', 'edit']);
        Route::resource('/stock/category',  'Stock\ProductCategoryController',['names' => 'product-category'])->except(['create', 'show', 'edit']);
        Route::resource('/stock/units',  'Stock\UnitController')->except(['create', 'show', 'edit']);
        Route::resource('/stock/brand',  'Stock\BrandController')->except(['create', 'show', 'edit']);
        Route::resource('/stock/company',  'Stock\CompanyController')->except(['create', 'show', 'edit']);

        Route::get('/stock/adjustment/item/{id}',  'Stock\AdjustmentController@get_items')->name('get_item');//Adjustment Item API
        Route::resource('/stock/adjustment',  'Stock\AdjustmentController')->except(['create', 'show', 'edit']);

        Route::put('/supplier/payment/{id}',  'Supplier\SupplierController@due_payment')->name('supplier.payment');
        Route::resource('/supplier/list',  'Supplier\SupplierController',['names' => 'supplier'])->except(['create', 'edit']);
        Route::resource('/supplier/category',  'Supplier\SupplierCategoryController',['names' => 'supplier-category'])->except(['create', 'show', 'edit']);

        Route::resource('/expenses',  'Expense\ExpenseController')->except(['create', 'show', 'edit']);
        Route::resource('/expenses/category',  'Expense\ExpenseCategoryController',['names' => 'expense-category'])->except(['create', 'show', 'edit']);

        Route::put('/accounts/payment/{id}',  'Accounts\AccountsController@payment')->name('accounts.payment');
        Route::get('/accounts/balance-sheet',  'Accounts\AccountActionController@balance_sheet')->name('accounts.balance');
        Route::get('/accounts/trial-balance',  'Accounts\AccountActionController@trial_balance')->name('accounts.trial');
        Route::get('/accounts/cash-flow',  'Accounts\AccountActionController@cash_flow')->name('accounts.cash');
        Route::get('/accounts/account-report',  'Accounts\AccountActionController@payment_report')->name('accounts.report');
        Route::resource('/accounts/transactions',  'Accounts\AccountActionController')->except(['index', 'store', 'create', 'show', 'edit']);
        Route::resource('/accounts/list',  'Accounts\AccountsController',['names' => 'accounts'])->except(['create', 'edit']);

        Route::resource('/settings/business',  'Settings\BusinessController')->only(['show', 'update']);
        Route::resource('/settings/warehouse',  'Settings\WareHouseController')->except(['create', 'show', 'edit']);
        Route::resource('/settings/discount',  'Settings\DiscountController')->except(['create', 'show', 'edit']);
        Route::resource('/settings/shipment',  'Settings\ShipmentController')->except(['create', 'show', 'edit']);
        Route::resource('/settings/vat-tax',  'Settings\VatTaxController')->except(['create', 'show', 'edit']);
        Route::resource('/settings/zone',  'Settings\ZoneController')->except(['create', 'show', 'edit']);


        Route::put('/users/roles/permission/{role}',  'User\RolesController@assign_role')->name('role.permission');
        Route::resource('/users/roles',  'User\RolesController')->except(['create', 'show', 'edit']);
        Route::resource('/users',  'User\UserController')->except(['create', 'show', 'edit']);

        Route::post('/reports/sales-profit',  'Report\ReportsController@sales_profit')->name('reports.sales-profit');
        Route::post('/reports/profit-loss',  'Report\ReportsController@profit_lose')->name('reports.profit-loss_action');
        Route::get('/reports/profit-loss',  'Report\ReportsController@index')->name('reports.profit-loss');

        Route::post('/reports/expense',  'Report\ExpenseController@reports')->name('reports.expense-report');
        Route::get('/reports/expense',  'Report\ExpenseController@index')->name('reports.expense');

        Route::post('/reports/accounts-book',  'Report\AccountsController@reports')->name('reports.accounts_book');
        Route::get('/reports/accounts',  'Report\AccountsController@index')->name('reports.accounts');

        Route::get('/reports/supplier',  'Report\SupplierController@index')->name('reports.supplier');


        Route::post('/reports/customer-single-ledger',  'Report\CustomerController@single_customer')->name('reports.customer_single');
        Route::post('/reports/customer-all-ledger',  'Report\CustomerController@all_customer')->name('reports.customer_all');
        Route::get('/reports/customer',  'Report\CustomerController@index')->name('reports.customer');

        Route::post('/reports/sales-invoice-due',  'Report\SalesController@due')->name('reports.sales_invoice_due');
        Route::post('/reports/sales-invoice',  'Report\SalesController@invoice')->name('reports.sales_invoice');
        Route::post('/reports/sales-invoice-item',  'Report\SalesController@items')->name('reports.sales_items');
        Route::get('/reports/sales',  'Report\SalesController@index')->name('reports.sales');

        Route::post('/reports/purchase-invoice',  'Report\PurchaseController@invoice')->name('reports.purchase_invoice');
        Route::post('/reports/purchase-invoice-item',  'Report\PurchaseController@items')->name('reports.purchase_items');
        Route::get('/reports/purchase',  'Report\PurchaseController@index')->name('reports.purchase');

        Route::post('/reports/stock-product',  'Report\StockController@reports')->name('reports.stock-product');
        Route::post('/reports/stock-transaction',  'Report\StockController@transaction')->name('reports.stock-transaction');
        Route::get('/reports/stock',  'Report\StockController@index')->name('reports.stock');

    });

    Route::post('/key', 'MainController@active')->name('key.active');
    Route::get('/key', 'MainController@activate')->name('key');
});


//==================== Backup Database =======================
Route::get('/catch', 'MainController@catches')->name('catches');
//==================== /Backup Database =======================

//==================== Backup Database =======================
Route::get('/backup', 'MainController@backup')->name('backup');
//==================== /Backup Database =======================

//==================== Toggle Sidebar =======================
Route::get('/savestate', 'MainController@saveState')->name('sidebar');
//Route::get('key', 'MainController@key');
//==================== /Toggle Sidebar =======================

//==================== Testing Option =======================
Route::get('/testing', 'MainController@test')->name('testing');
//==================== /Testing Option =======================

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
