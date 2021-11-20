<?php

namespace App;

use App\Scopes\BusinessScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property integer $warehouses_id
 * @property integer $products_id
 * @property integer $purchase_invoices_id
 * @property integer $business_id
 * @property integer $users_id
 * @property string $name
 * @property string $sku
 * @property string $batch_no
 * @property string $expire_date
 * @property float $quantity
 * @property float $amount
 * @property string $unit
 * @property string $discount_type
 * @property float $discount_amount
 * @property string $deleted_at
 * @property string $created_at
 * @property string $updated_at
 * @property Business $business
 * @property Product $product
 * @property PurchaseInvoice $purchaseInvoice
 * @property User $users
 * @property Warehouse $warehouse
 * @property StockTransaction[] $stockTransactions
 */
class PurchaseItem extends Model
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
    protected $fillable = ['status', 'warehouses_id', 'products_id', 'purchase_invoices_id', 'business_id', 'users_id', 'name', 'sku', 'batch_no', 'expire_date', 'quantity', 'amount', 'unit', 'discount_type', 'discount_amount', 'vat_amount', 'deleted_at', 'created_at', 'updated_at'];

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
    public function product()
    {
        return $this->belongsTo('App\Product', 'products_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function purchaseInvoice()
    {
        return $this->belongsTo('App\PurchaseInvoice', 'purchase_invoices_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'users_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function warehouse()
    {
        return $this->belongsTo('App\Warehouse', 'warehouses_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stockTransactions()
    {
        return $this->hasMany('App\StockTransaction', 'purchase_items_id');
    }

    public function setCreatedAtAttribute($value)
    {
        $this->attributes['created_at'] = db_date($value);
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new BusinessScope);
    }
}
