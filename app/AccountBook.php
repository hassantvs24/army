<?php

namespace App;

use App\Scopes\BusinessScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property integer $warehouses_id
 * @property integer $business_id
 * @property integer $users_id
 * @property string $name
 * @property string $account_number
 * @property mixed $description
 * @property boolean $status
 * @property string $deleted_at
 * @property string $created_at
 * @property string $updated_at
 * @property Business $business
 * @property User $users
 * @property Warehouse $warehouse
 * @property AgentTransaction[] $agentTransactions
 * @property AllTransaction[] $allTransactions
 * @property CustomerTransaction[] $customerTransactions
 * @property PurchaseTransaction[] $purchaseTransactions
 * @property SellTransaction[] $sellTransactions
 * @property SupplierTransaction[] $supplierTransactions
 * @property VatTaxTransaction[] $vatTaxTransactions
 */
class AccountBook extends Model
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
    protected $fillable = ['warehouses_id', 'business_id', 'users_id', 'name', 'account_number', 'description', 'status', 'deleted_at', 'created_at', 'updated_at'];

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
    public function transactions()
    {
        return $this->hasMany('App\Transaction', 'account_books_id');
    }


    public function in(){
        return $this->transactions()->where('transaction_type', 'IN')->where('status', 'Active')->sum('amount');
    }

    public function out(){
        return $this->transactions()->where('transaction_type', 'OUT')->where('status', 'Active')->sum('amount');
    }

    public function acBalance()
    {
        $total = $this->in() - $this->out();
        return $total;
    }

    public function bankBalance(){
        $in_ac = $this->transactions()->where('transaction_type', 'IN')->whereIn('payment_method', ['Card', 'Cheque', 'Bank Transfer'])->where('status', 'Active')->sum('amount');
        $out_ac = $this->transactions()->where('transaction_type', 'OUT')->whereIn('payment_method', ['Card', 'Cheque', 'Bank Transfer'])->where('status', 'Active')->sum('amount');
        return $in_ac - $out_ac;
    }

    public function cashBalance(){
        $in_ac = $this->transactions()->where('transaction_type', 'IN')->whereNotIn('payment_method', ['Card', 'Cheque', 'Bank Transfer'])->where('status', 'Active')->sum('amount');
        $out_ac = $this->transactions()->where('transaction_type', 'OUT')->whereNotIn('payment_method', ['Card', 'Cheque', 'Bank Transfer'])->where('status', 'Active')->sum('amount');
        return $in_ac - $out_ac;
    }

    public function getTotalBalanceAttribute()
    {
        return $this->acBalance();
    }

    /**
     * Add Global Scope where selected business id getting from Auth
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new BusinessScope);
    }
}
