<?php

namespace App;

use App\Scopes\BusinessScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property integer $customers_id
 * @property integer $sell_invoices_id
 * @property integer $suppliers_id
 * @property integer $purchase_invoices_id
 * @property integer $vet_texes_id
 * @property integer $warehouses_id
 * @property integer $business_id
 * @property integer $users_id
 * @property string $code
 * @property string $document
 * @property string $return_type
 * @property string $deleted_at
 * @property string $created_at
 * @property string $updated_at
 * @property Business $business
 * @property Customer $customer
 * @property PurchaseInvoice $purchaseInvoice
 * @property SellInvoice $sellInvoice
 * @property Supplier $supplier
 * @property User $users
 * @property VetTex $vetTex
 * @property Warehouse $warehouse
 * @property ProductReturnItem[] $productReturnItems
 */
class ProductReturn extends Model
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
    protected $fillable = ['customers_id', 'sell_invoices_id', 'suppliers_id', 'purchase_invoices_id', 'vet_texes_id', 'warehouses_id', 'business_id', 'users_id', 'code', 'document', 'return_type', 'deleted_at', 'created_at', 'updated_at'];

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
    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customers_id');
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
    public function sellInvoice()
    {
        return $this->belongsTo('App\SellInvoice', 'sell_invoices_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supplier()
    {
        return $this->belongsTo('App\Supplier', 'suppliers_id');
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
    public function vetTex()
    {
        return $this->belongsTo('App\VetTex', 'vet_texes_id');
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
    public function productReturnItems()
    {
        return $this->hasMany('App\ProductReturnItem', 'product_returns_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new BusinessScope);
    }
}
