<?php

namespace App;

use App\Scopes\BusinessScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property integer $products_id
 * @property integer $warehouses_id
 * @property integer $product_returns_id
 * @property integer $business_id
 * @property integer $users_id
 * @property string $return_type
 * @property string $name
 * @property string $sku
 * @property string $batch_no
 * @property string $expire_date
 * @property float $quantity
 * @property float $amount
 * @property string $unit
 * @property string $deleted_at
 * @property string $created_at
 * @property string $updated_at
 * @property Business $business
 * @property ProductReturn $productReturn
 * @property Product $product
 * @property User $users
 * @property Warehouse $warehouse
 * @property StockTransaction[] $stockTransactions
 */
class ProductReturnItem extends Model
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
    protected $fillable = ['products_id', 'warehouses_id', 'product_returns_id', 'business_id', 'users_id', 'return_type', 'name', 'sku', 'batch_no', 'expire_date', 'quantity', 'amount', 'unit', 'deleted_at', 'created_at', 'updated_at'];

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
    public function productReturn()
    {
        return $this->belongsTo('App\ProductReturn', 'product_returns_id');
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
        return $this->hasMany('App\StockTransaction', 'product_return_items_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new BusinessScope);
    }
}
