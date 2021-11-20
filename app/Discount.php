<?php

namespace App;

use App\Scopes\BusinessScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property integer $warehouses_id
 * @property integer $brands_id
 * @property integer $product_categories_id
 * @property integer $customer_categories_id
 * @property integer $business_id
 * @property integer $users_id
 * @property string $name
 * @property int $priority
 * @property float $amount
 * @property string $apply_only
 * @property string $discount_type
 * @property boolean $status
 * @property string $start
 * @property string $end
 * @property string $deleted_at
 * @property string $created_at
 * @property string $updated_at
 * @property Brand $brand
 * @property Business $business
 * @property CustomerCategory $customerCategory
 * @property ProductCategory $productCategory
 * @property User $users
 * @property Warehouse $warehouse
 * @property PurchaseInvoice[] $purchaseInvoices
 * @property SellInvoice[] $sellInvoices
 */
class Discount extends Model
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
    protected $fillable = ['warehouses_id', 'brands_id', 'product_categories_id', 'customer_categories_id', 'business_id', 'users_id', 'name', 'priority', 'amount', 'apply_only', 'discount_type', 'status', 'start', 'end', 'deleted_at', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo('App\Brand', 'brands_id');
    }

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
    public function customerCategory()
    {
        return $this->belongsTo('App\CustomerCategory', 'customer_categories_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productCategory()
    {
        return $this->belongsTo('App\ProductCategory', 'product_categories_id');
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
    public function purchaseInvoices()
    {
        return $this->hasMany('App\PurchaseInvoice', 'discounts_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sellInvoices()
    {
        return $this->hasMany('App\SellInvoice', 'discounts_id');
    }

    public function getDiscountTypeAttribute($value)
    {
        return ($value == 'Fixed'?'':'%');
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new BusinessScope);
    }
}
