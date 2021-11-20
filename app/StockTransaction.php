<?php

namespace App;

use App\Scopes\BusinessScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property integer $products_id
 * @property integer $invoice_items_id
 * @property integer $purchase_items_id
 * @property integer $product_return_items_id
 * @property integer $stock_adjustment_items_id
 * @property integer $stock_transfer_items_id
 * @property integer $business_id
 * @property integer $users_id
 * @property string $transaction_point
 * @property string $transaction_type
 * @property string $name
 * @property string $sku
 * @property string $batch_no
 * @property float $amount
 * @property float $quantity
 * @property string $unit
 * @property string $deleted_at
 * @property string $created_at
 * @property string $updated_at
 * @property Business $business
 * @property InvoiceItem $invoiceItem
 * @property ProductReturnItem $productReturnItem
 * @property Product $product
 * @property PurchaseItem $purchaseItem
 * @property StockAdjustmentItem $stockAdjustmentItem
 * @property StockTransferItem $stockTransferItem
 * @property User $users
 */
class StockTransaction extends Model
{

    //use SoftDeletes;
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['status', 'products_id', 'invoice_items_id', 'purchase_items_id', 'product_return_items_id', 'stock_adjustment_items_id', 'stock_transfer_items_id', 'warehouses_id', 'business_id', 'users_id', 'transaction_point', 'transaction_type', 'name', 'sku', 'batch_no', 'amount', 'quantity', 'unit', 'deleted_at', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function business()
    {
        return $this->belongsTo('App\Business');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invoiceItem()
    {
        return $this->belongsTo('App\InvoiceItem', 'invoice_items_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productReturnItem()
    {
        return $this->belongsTo('App\ProductReturnItem', 'product_return_items_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\Product', 'products_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function purchaseItem()
    {
        return $this->belongsTo('App\PurchaseItem', 'purchase_items_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stockAdjustmentItem()
    {
        return $this->belongsTo('App\StockAdjustmentItem', 'stock_adjustment_items_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function warehouse()
    {
        return $this->belongsTo('App\Warehouse', 'warehouses_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stockTransferItem()
    {
        return $this->belongsTo('App\StockTransferItem', 'stock_transfer_items_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'users_id');
    }

    public function in(){
        return ($this->transaction_type == 'IN' ? $this->quantity : 0);
    }

    public function out(){
        return ($this->transaction_type == 'OUT' ? $this->quantity : 0);
    }

    public function ref(){

        switch ($this->transaction_point) {
            case "Sells":
                $sendCol = $this->invoiceItem->sellInvoice['code'];
                break;
            case "Sells Return":
                $sendCol = $this->productReturnItem->productReturn['code'];
                break;
            case "Purchase":
                $sendCol = $this->purchaseItem->purchaseInvoice['code'];
                break;
            case "Purchase Return":
                $sendCol = $this->productReturnItem->productReturn['code'];
                break;
            case "Adjustment":
                $sendCol = $this->stockAdjustmentItem->stockAdjustment['code'];
                break;
            case "Transfer":
                $sendCol = $this->stockTransferItem->stockTransfer['code'];
                break;
            default:
                $sendCol = "Opening Stock";
        }

        return $sendCol;
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new BusinessScope);
    }


}
