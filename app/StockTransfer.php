<?php

namespace App;

use App\Scopes\BusinessScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property integer $from_warehouse_id
 * @property integer $to_warehouse_id
 * @property integer $business_id
 * @property integer $users_id
 * @property string $code
 * @property string $document
 * @property float $shipping_charges
 * @property mixed $description
 * @property string $deleted_at
 * @property string $created_at
 * @property string $updated_at
 * @property Business $business
 * @property Warehouse $warehouse
 * @property User $users
 * @property AllTransaction[] $allTransactions
 * @property StockTransferItem[] $stockTransferItems
 */
class StockTransfer extends Model
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
    protected $fillable = ['from_warehouse_id', 'to_warehouse_id', 'business_id', 'users_id', 'code', 'document', 'shipping_charges', 'description', 'deleted_at', 'created_at', 'updated_at'];

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
    public function warehouse_from()
    {
        return $this->belongsTo('App\Warehouse', 'from_warehouse_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function warehouse_to()
    {
        return $this->belongsTo('App\Warehouse', 'to_warehouse_id');
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
    public function stockTransferItems()
    {
        return $this->hasMany('App\StockTransferItem', 'stock_transfers_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new BusinessScope);
    }
}
