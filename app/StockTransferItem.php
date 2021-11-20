<?php

namespace App;

use App\Scopes\BusinessScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property integer $products_id
 * @property integer $stock_transfers_id
 * @property integer $business_id
 * @property integer $users_id
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
 * @property Product $product
 * @property StockTransfer $stockTransfer
 * @property User $users
 * @property StockTransaction[] $stockTransactions
 */
class StockTransferItem extends Model
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
    protected $fillable = ['products_id', 'stock_transfers_id', 'business_id', 'users_id', 'name', 'sku', 'batch_no', 'expire_date', 'quantity', 'amount', 'unit', 'deleted_at', 'created_at', 'updated_at'];

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
    public function stockTransfer()
    {
        return $this->belongsTo('App\StockTransfer', 'stock_transfers_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'users_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stockTransactions()
    {
        return $this->hasMany('App\StockTransaction', 'stock_transfer_items_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new BusinessScope);
    }
}
