<?php

namespace App\Observers;

use App\PurchaseInvoice;
use App\PurchaseItem;
use App\Transaction;

class PurchaseObserver
{
    /**
     * Handle the purchase invoice "created" event.
     *
     * @param  \App\PurchaseInvoice  $purchaseInvoice
     * @return void
     */
    public function created(PurchaseInvoice $purchaseInvoice)
    {
        //
    }

    /**
     * Handle the purchase invoice "updated" event.
     *
     * @param  \App\PurchaseInvoice  $purchaseInvoice
     * @return void
     */
    public function updated(PurchaseInvoice $purchaseInvoice)
    {
//        $ck_status = ($purchaseInvoice->status == 'Pending' ? 'Inactive':'Active');
//        Transaction::where('sell_invoices_id', $purchaseInvoice->id)->update([
//            'customers_id' => $purchaseInvoice->suppliers_id,
//            'status' => $ck_status
//        ]);
    }

    /**
     * Handle the purchase invoice "deleted" event.
     *
     * @param  \App\PurchaseInvoice  $purchaseInvoice
     * @return void
     */
    public function deleted(PurchaseInvoice $purchaseInvoice)
    {
        PurchaseItem::where('purchase_invoices_id', $purchaseInvoice->id)->delete();
        Transaction::where('purchase_invoices_id', $purchaseInvoice->id)->delete();
    }

    /**
     * Handle the purchase invoice "restored" event.
     *
     * @param  \App\PurchaseInvoice  $purchaseInvoice
     * @return void
     */
    public function restored(PurchaseInvoice $purchaseInvoice)
    {
        PurchaseItem::onlyTrashed()->where('purchase_invoices_id', $purchaseInvoice->id)->restore();
        Transaction::onlyTrashed()->where('purchase_invoices_id', $purchaseInvoice->id)->restore();
    }

    /**
     * Handle the purchase invoice "force deleted" event.
     *
     * @param  \App\PurchaseInvoice  $purchaseInvoice
     * @return void
     */
    public function forceDeleted(PurchaseInvoice $purchaseInvoice)
    {
        PurchaseItem::where('purchase_invoices_id', $purchaseInvoice->id)->forceDelete();
        Transaction::where('purchase_invoices_id', $purchaseInvoice->id)->forceDelete();
    }
}
