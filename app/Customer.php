<?php

namespace App;

use App\Scopes\BusinessScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property integer $zones_id
 * @property integer $unions_id
 * @property integer $upa_zillas_id
 * @property integer $zillas_id
 * @property integer $divisions_id
 * @property integer $vet_texes_id
 * @property integer $customer_categories_id
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
 * @property string $image
 * @property string $pay_term
 * @property float $credit_limit
 * @property float $balance
 * @property float $sells_target
 * @property string $deleted_at
 * @property string $created_at
 * @property string $updated_at
 * @property Business $business
 * @property CustomerCategory $customerCategory
 * @property Division $division
 * @property Union $union
 * @property UpaZilla $upaZilla
 * @property User $users
 * @property VetTex $vetTex
 * @property Warehouse $warehouse
 * @property Zilla $zilla
 * @property Zone $zone
 * @property CustomerTransaction[] $customerTransactions
 * @property ProductReturn[] $productReturns
 * @property SellInvoice[] $sellInvoices
 * @property SellTransaction[] $sellTransactions
 */
class Customer extends Model
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
    protected $fillable = ['zones_id', 'contact_person', 'agent_id', 'unions_id', 'upa_zillas_id', 'zillas_id', 'divisions_id', 'vet_texes_id', 'customer_categories_id', 'warehouses_id', 'business_id', 'users_id', 'name', 'code', 'address', 'email', 'contact', 'phone', 'alternate_contact', 'description', 'image', 'pay_term', 'credit_limit', 'balance', 'sells_target', 'deleted_at', 'created_at', 'updated_at'];

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
    public function division()
    {
        return $this->belongsTo('App\Division', 'divisions_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function union()
    {
        return $this->belongsTo('App\Union', 'unions_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function upaZilla()
    {
        return $this->belongsTo('App\UpaZilla', 'upa_zillas_id');
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function zilla()
    {
        return $this->belongsTo('App\Zilla', 'zillas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function zone()
    {
        return $this->belongsTo('App\Zone', 'zones_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agent()
    {
        return $this->belongsTo('App\Agent', 'agent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productReturns()
    {
        return $this->hasMany('App\ProductReturn', 'customers_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sellInvoices()
    {
        return $this->hasMany('App\SellInvoice', 'customers_id');
    }

    public function transactions()
    {
        return $this->hasMany('App\Transaction', 'customers_id');
    }

    public function totalPayment(){
        $total_in = $this->transactions()->where('transaction_type', 'IN')->where('status', 'Active')->sum('amount');
        $total_out = $this->transactions()->where('transaction_type', 'OUT')->where('status', 'Active')->sum('amount');
        $total = $total_in - $total_out;
        return $total;
    }

    public function totalAcPayment(){
            $total_in = $this->transactions()->where('transaction_type', 'IN')->where('transaction_point', 'Customer Account')->where('status', 'Active')->sum('amount');
            $total_out = $this->transactions()->where('transaction_type', 'OUT')->where('status', 'Active')->sum('amount');
            $total = $total_in - $total_out;
            return $total;
    }

    public function totalSales(){
        $invoices = $this->sellInvoices()->where('status', 'Final')->get();
        $labor_cost = 0;
        $discount_amount = 0;
        $vet_texes_amount = 0;
        $shipping_charges = 0;
        $additional_charges = 0;
        $total_sales = 0;

        foreach ($invoices as $row){
            $labor_cost += $row->labor_cost;
            $discount_amount += $row->discount_amount;
            $vet_texes_amount += $row->vet_texes_amount;
            $shipping_charges += $row->shipping_charges;
            $additional_charges += $row->additional_charges;
            $total_sales += $row->invoice_total();
        }
        $total = $total_sales + $labor_cost + $vet_texes_amount + $shipping_charges + $additional_charges - $discount_amount;

        return $total;
    }

    public function dueBalance(){
        $total_paid = $this->totalPayment();
        $total_amount = $this->totalSales();

        $total = $total_paid - $total_amount;

        return $total;
    }

    public function dueBalancex(){
        $total_paid = $this->totalPayment();
        $total_amount = $this->totalSales();

        $total = $total_amount - $total_paid;

        return $total;
    }


    public function daily($data){
        $invoice = $this->sellInvoices()->whereDate('created_at', $data)->where('status', 'Final')->get();
        $invoice_total = $invoice->sum('SubTotal');
        $transaction_out = $this->transactions()->whereDate('created_at', $data)->where('transaction_type', 'OUT')->where('status', 'Active')->sum('amount');
        $out = $invoice_total + $transaction_out;
        $in = $this->transactions()->whereDate('created_at', $data)->where('transaction_type', 'IN')->where('status', 'Active')->sum('amount');

        return array('in' => $in, 'out' => $out);
    }


    public function getSalesAttribute()
    {
        return $this->totalSales();
    }

    public function getSalesDueAttribute()
    {
        return -$this->dueBalance();
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new BusinessScope);
    }
}
