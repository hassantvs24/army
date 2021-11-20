<?php

namespace App;

use App\Scopes\BusinessScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property integer $warehouses_id
 * @property integer $products_id
 * @property integer $sell_invoices_id
 * @property integer $business_id
 * @property integer $users_id
 * @property string $name
 * @property string $sku
 * @property string $batch_no
 * @property float $purchase_amount
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
 * @property SellInvoice $sellInvoice
 * @property User $users
 * @property Warehouse $warehouse
 * @property StockTransaction[] $stockTransactions
 */
class InvoiceItem extends Model
{
   // use SoftDeletes;
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['status', 'warehouses_id', 'products_id', 'sell_invoices_id', 'business_id', 'users_id', 'name', 'sku', 'batch_no', 'purchase_amount', 'quantity', 'amount', 'unit', 'discount_type', 'discount_amount', 'vat_amount', 'deleted_at', 'created_at', 'updated_at'];

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
    public function sellInvoice()
    {
        return $this->belongsTo('App\SellInvoice', 'sell_invoices_id');
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
        return $this->hasMany('App\StockTransaction', 'invoice_items_id');
    }

    public function setCreatedAtAttribute($value)
    {
        $this->attributes['created_at'] = db_date($value);
    }


    public function getAmountAttribute($value){
        $less = $this->discount_amount;
        if($this->discount_type == 'Percentage'){
            $less = $value * $this->discount_amount / 100;
        }

        return $value - $less;
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new BusinessScope);
    }
}
