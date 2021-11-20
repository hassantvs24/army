<?php

namespace App;

use App\Scopes\BusinessScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property integer $products_id
 * @property integer $warehouses_id
 * @property integer $stock_adjustments_id
 * @property integer $business_id
 * @property integer $users_id
 * @property string $name
 * @property string $sku
 * @property string $batch_no
 * @property string $expire_date
 * @property float $quantity
 * @property float $amount
 * @property string $unit
 * @property string $adjustment_action
 * @property string $deleted_at
 * @property string $created_at
 * @property string $updated_at
 * @property Business $business
 * @property Product $product
 * @property StockAdjustment $stockAdjustment
 * @property User $users
 * @property Warehouse $warehouse
 * @property StockTransaction[] $stockTransactions
 */
class StockAdjustmentItem extends Model
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
    protected $fillable = ['products_id', 'warehouses_id', 'stock_adjustments_id', 'business_id', 'users_id', 'name', 'sku', 'batch_no', 'expire_date', 'quantity', 'amount', 'unit', 'adjustment_action', 'deleted_at', 'created_at', 'updated_at'];

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
    public function stockAdjustment()
    {
        return $this->belongsTo('App\StockAdjustment', 'stock_adjustments_id');
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
        return $this->hasMany('App\StockTransaction', 'stock_adjustment_items_id');
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
