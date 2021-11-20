<?php

namespace App;

use App\Scopes\BusinessScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property integer $vet_texes_id
 * @property integer $supplier_categories_id
 * @property integer $warehouses_id
 * @property integer $business_id
 * @property integer $users_id
 * @property string $name
 * @property string $code
 * @property string $address
 * @property string $email
 * @property string $contact
 * @property string $phone
 * @property string $alternate_contact
 * @property mixed $description
 * @property string $pay_term
 * @property float $credit_limit
 * @property float $balance
 * @property string $deleted_at
 * @property string $created_at
 * @property string $updated_at
 * @property Business $business
 * @property SupplierCategory $supplierCategory
 * @property User $users
 * @property VetTex $vetTex
 * @property Warehouse $warehouse
 * @property ProductReturn[] $productReturns
 * @property PurchaseInvoice[] $purchaseInvoices
 * @property PurchaseTransaction[] $purchaseTransactions
 * @property SupplierTransaction[] $supplierTransactions
 */
class Supplier extends Model
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
    protected $fillable = ['vet_texes_id', 'supplier_categories_id', 'warehouses_id', 'business_id', 'users_id', 'name', 'code', 'address', 'email', 'contact', 'phone', 'alternate_contact', 'description', 'pay_term', 'credit_limit', 'balance', 'deleted_at', 'created_at', 'updated_at'];

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
    public function supplierCategory()
    {
        return $this->belongsTo('App\SupplierCategory', 'supplier_categories_id');
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
    public function productReturns()
    {
        return $this->hasMany('App\ProductReturn', 'suppliers_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchaseInvoices()
    {
        return $this->hasMany('App\PurchaseInvoice', 'suppliers_id');
    }


    public function transactions()
    {
        return $this->hasMany('App\Transaction', 'suppliers_id');
    }

    public function totalPayment(){
        $total_in = $this->transactions()->where('transaction_type', 'IN')->where('status', 'Active')->sum('amount');//IN based on supplier not business
        $total_out = $this->transactions()->where('transaction_type', 'OUT')->where('status', 'Active')->sum('amount');//OUT based on business not supplier
        $total = $total_out - $total_in;
        return $total;
    }

    public function totalAcPayment(){
        $total_in = $this->transactions()->where('transaction_type', 'IN')->where('status', 'Active')->sum('amount');//IN based on supplier not business
        $total_out = $this->transactions()->where('transaction_type', 'OUT')->where('transaction_point', 'Supplier Account')->where('status', 'Active')->sum('amount');//OUT based on business not supplier
        $total = $total_out - $total_in;
        return $total;
    }

    public function totalPurchase(){
        $invoices = $this->purchaseInvoices()->where('status', '<>', 'Pending')->get();
        $labor_cost = 0;
        $discount_amount = 0;
        $vet_texes_amount = 0;
        $shipping_charges = 0;
        $additional_charges = 0;
        $total_purchase = 0;

        foreach ($invoices as $row){
            $labor_cost += $row->labor_cost;
            $discount_amount += $row->discount_amount;
            $vet_texes_amount += $row->vet_texes_amount;
            $shipping_charges += $row->shipping_charges;
            $additional_charges += $row->additional_charges;
            $total_purchase += $row->invoice_total();
        }
        $total = $total_purchase + $labor_cost + $vet_texes_amount + $shipping_charges + $additional_charges - $discount_amount;

        return $total;
    }

    public function dueBalance(){
        $total_paid = $this->totalPayment();
        $total_amount = $this->totalPurchase();

        $total = $total_amount - $total_paid;

        return $total;
    }

    public function getPurchaseDueAttribute()
    {
        return $this->dueBalance();
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new BusinessScope);
    }
}
