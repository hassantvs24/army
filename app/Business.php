<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property string $name
 * @property string $contact
 * @property string $contact_alternate
 * @property string $phone
 * @property string $address
 * @property string $email
 * @property string $website
 * @property string $proprietor
 * @property string $logo
 * @property string $key
 * @property string $deleted_at
 * @property string $created_at
 * @property string $updated_at
 * @property AccountBook[] $accountBooks
 * @property AgentTransaction[] $agentTransactions
 * @property Agent[] $agents
 * @property AllTransaction[] $allTransactions
 * @property Brand[] $brands
 * @property Company[] $companies
 * @property CustomerCategory[] $customerCategories
 * @property CustomerTransaction[] $customerTransactions
 * @property Customer[] $customers
 * @property Discount[] $discounts
 * @property Division[] $divisions
 * @property ExpenseCategory[] $expenseCategories
 * @property Expense[] $expenses
 * @property InvoiceItem[] $invoiceItems
 * @property ProductCategory[] $productCategories
 * @property ProductReturnItem[] $productReturnItems
 * @property ProductReturn[] $productReturns
 * @property Product[] $products
 * @property PurchaseInvoice[] $purchaseInvoices
 * @property PurchaseItem[] $purchaseItems
 * @property PurchaseTransaction[] $purchaseTransactions
 * @property RolesAccess[] $rolesAccesses
 * @property SellInvoice[] $sellInvoices
 * @property SellTransaction[] $sellTransactions
 * @property Shipment[] $shipments
 * @property StockAdjustmentItem[] $stockAdjustmentItems
 * @property StockAdjustment[] $stockAdjustments
 * @property StockTransaction[] $stockTransactions
 * @property StockTransferItem[] $stockTransferItems
 * @property StockTransfer[] $stockTransfers
 * @property SupplierCategory[] $supplierCategories
 * @property SupplierTransaction[] $supplierTransactions
 * @property Supplier[] $suppliers
 * @property Union[] $unions
 * @property Unit[] $units
 * @property UpaZilla[] $upaZillas
 * @property UserRole[] $userRoles
 * @property User[] $users
 * @property VatTaxTransaction[] $vatTaxTransactions
 * @property VetTex[] $vetTexes
 * @property Warehouse[] $warehouses
 * @property Zilla[] $zillas
 * @property Zone[] $zones
 */
class Business extends Model
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
    protected $fillable = ['name', 'contact', 'contact_alternate', 'phone', 'address', 'email', 'website', 'proprietor', 'logo', 'software_key', 'deleted_at', 'created_at', 'updated_at'];


    public function getLogoAttribute($value)
    {
        return asset("public/$value");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accountBooks()
    {
        return $this->hasMany('App\AccountBook');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agents()
    {
        return $this->hasMany('App\Agent');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function brands()
    {
        return $this->hasMany('App\Brand');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function companies()
    {
        return $this->hasMany('App\Company');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function customerCategories()
    {
        return $this->hasMany('App\CustomerCategory');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function customers()
    {
        return $this->hasMany('App\Customer');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function discounts()
    {
        return $this->hasMany('App\Discount');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function divisions()
    {
        return $this->hasMany('App\Division');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function expenseCategories()
    {
        return $this->hasMany('App\ExpenseCategory');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function expenses()
    {
        return $this->hasMany('App\Expense');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoiceItems()
    {
        return $this->hasMany('App\InvoiceItem');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productCategories()
    {
        return $this->hasMany('App\ProductCategory');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productReturnItems()
    {
        return $this->hasMany('App\ProductReturnItem');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productReturns()
    {
        return $this->hasMany('App\ProductReturn');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany('App\Product');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchaseInvoices()
    {
        return $this->hasMany('App\PurchaseInvoice');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchaseItems()
    {
        return $this->hasMany('App\PurchaseItem');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rolesAccesses()
    {
        return $this->hasMany('App\RolesAccess');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sellInvoices()
    {
        return $this->hasMany('App\SellInvoice');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shipments()
    {
        return $this->hasMany('App\Shipment');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stockAdjustmentItems()
    {
        return $this->hasMany('App\StockAdjustmentItem');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stockAdjustments()
    {
        return $this->hasMany('App\StockAdjustment');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stockTransactions()
    {
        return $this->hasMany('App\StockTransaction');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stockTransferItems()
    {
        return $this->hasMany('App\StockTransferItem');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stockTransfers()
    {
        return $this->hasMany('App\StockTransfer');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function supplierCategories()
    {
        return $this->hasMany('App\SupplierCategory');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function suppliers()
    {
        return $this->hasMany('App\Supplier');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function unions()
    {
        return $this->hasMany('App\Union');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function units()
    {
        return $this->hasMany('App\Unit');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function upaZillas()
    {
        return $this->hasMany('App\UpaZilla');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userRoles()
    {
        return $this->hasMany('App\UserRole');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vetTexes()
    {
        return $this->hasMany('App\VetTex');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function warehouses()
    {
        return $this->hasMany('App\Warehouse');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function zillas()
    {
        return $this->hasMany('App\Zilla');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function zones()
    {
        return $this->hasMany('App\Zone');
    }



}
