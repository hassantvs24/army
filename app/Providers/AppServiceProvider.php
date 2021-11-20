<?php

namespace App\Providers;

use App\Expense;
use App\Observers\ExpenseObserver;
use App\Observers\TransactionObserver;
use App\PurchaseItem;
use App\Observers\PurchaseItemObserver;
use App\PurchaseInvoice;
use App\Observers\PurchaseObserver;
use App\InvoiceItem;
use App\Observers\SalesItemOvserver;
use App\SellInvoice;
use App\Observers\SalesOvserver;
use App\Customer;
use App\Observers\CustomerObserver;
use App\Supplier;
use App\Observers\SupplierObserver;
use App\Observers\ProductObserver;
use App\Observers\StockAdjustmentItemObserver;
use App\Observers\StockAdjustmentObserver;
use App\Product;
use App\StockAdjustment;
use App\StockAdjustmentItem;
use App\Transaction;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        StockAdjustmentItem::observe(StockAdjustmentItemObserver::class);
        StockAdjustment::observe(StockAdjustmentObserver::class);
        Product::observe(ProductObserver::class);

        Supplier::observe(SupplierObserver::class);
        Customer::observe(CustomerObserver::class);

        SellInvoice::observe(SalesOvserver::class);
        InvoiceItem::observe(SalesItemOvserver::class);

        PurchaseInvoice::observe(PurchaseObserver::class);
        PurchaseItem::observe(PurchaseItemObserver::class);

        Transaction::observe(TransactionObserver::class);

        Expense::observe(ExpenseObserver::class);

    }
}
