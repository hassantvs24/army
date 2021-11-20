<?php

namespace App;

use App\Scopes\BusinessScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property integer $business_id
 * @property integer $users_id
 * @property string $name
 * @property string $contact
 * @property string $contact_alternate
 * @property string $phone
 * @property string $address
 * @property string $email
 * @property string $website
 * @property string $proprietor
 * @property string $logo
 * @property boolean $status
 * @property string $deleted_at
 * @property string $created_at
 * @property string $updated_at
 * @property Business $business
 * @property User $users
 * @property AccountBook[] $accountBooks
 * @property AgentTransaction[] $agentTransactions
 * @property Agent[] $agents
 * @property AllTransaction[] $allTransactions
 * @property CustomerTransaction[] $customerTransactions
 * @property Customer[] $customers
 * @property Discount[] $discounts
 * @property Expense[] $expenses
 * @property InvoiceItem[] $invoiceItems
 * @property ProductReturnItem[] $productReturnItems
 * @property ProductReturn[] $productReturns
 * @property PurchaseInvoice[] $purchaseInvoices
 * @property PurchaseItem[] $purchaseItems
 * @property PurchaseTransaction[] $purchaseTransactions
 * @property SellInvoice[] $sellInvoices
 * @property SellTransaction[] $sellTransactions
 * @property StockAdjustmentItem[] $stockAdjustmentItems
 * @property StockAdjustment[] $stockAdjustments
 * @property StockTransfer[] $stockTransfers
 * @property SupplierTransaction[] $supplierTransactions
 * @property Supplier[] $suppliers
 * @property VatTaxTransaction[] $vatTaxTransactions
 */
class Warehouse extends Model
{
  //  use SoftDeletes;

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['business_id', 'users_id', 'name', 'contact', 'contact_alternate', 'phone', 'address', 'email', 'website', 'proprietor', 'logo', 'status', 'deleted_at', 'created_at', 'updated_at'];

    public function getLogoAttribute($value)
    {
        return asset("public/$value");
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
    public function user()
    {
        return $this->belongsTo('App\User', 'users_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accountBooks()
    {
        return $this->hasMany('App\AccountBook', 'warehouses_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agents()
    {
        return $this->hasMany('App\Agent', 'warehouses_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany('App\Transaction', 'warehouses_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function customers()
    {
        return $this->hasMany('App\Customer', 'warehouses_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function discounts()
    {
        return $this->hasMany('App\Discount', 'warehouses_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function expenses()
    {
        return $this->hasMany('App\Expense', 'warehouses_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoiceItems()
    {
        return $this->hasMany('App\InvoiceItem', 'warehouses_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productReturnItems()
    {
        return $this->hasMany('App\ProductReturnItem', 'warehouses_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productReturns()
    {
        return $this->hasMany('App\ProductReturn', 'warehouses_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchaseInvoices()
    {
        return $this->hasMany('App\PurchaseInvoice', 'warehouses_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchaseItems()
    {
        return $this->hasMany('App\PurchaseItem', 'warehouses_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sellInvoices()
    {
        return $this->hasMany('App\SellInvoice', 'warehouses_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stockAdjustmentItems()
    {
        return $this->hasMany('App\StockAdjustmentItem', 'warehouses_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stockAdjustments()
    {
        return $this->hasMany('App\StockAdjustment', 'warehouses_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stockTransaction()
    {
        return $this->hasMany('App\StockTransaction', 'warehouses_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stockTransfers()
    {
        return $this->hasMany('App\StockTransfer', 'from_warehouse_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stockTransfersTo()
    {
        return $this->hasMany('App\StockTransfer', 'to_warehouse_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function suppliers()
    {
        return $this->hasMany('App\Supplier', 'warehouses_id');
    }


    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new BusinessScope);
    }
}
