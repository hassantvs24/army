<?php

namespace App;

use App\Scopes\BusinessScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * @property integer $id
 * @property integer $customers_id
 * @property integer $shipments_id
 * @property integer $discounts_id
 * @property integer $vet_texes_id
 * @property integer $agents_id
 * @property integer $warehouses_id
 * @property integer $business_id
 * @property integer $users_id
 * @property string $code
 * @property string $name
 * @property string $address
 * @property string $email
 * @property string $contact
 * @property string $status
 * @property string $payment_term
 * @property string $discount_type
 * @property string $agent_commission_type
 * @property float $labor_cost
 * @property float $discount_amount
 * @property float $agent_commission
 * @property float $vet_texes_amount
 * @property float $shipping_charges
 * @property float $additional_charges
 * @property float $previous_due
 * @property mixed $description
 * @property string $due_date
 * @property boolean $is_delivery
 * @property string $delivery_address
 * @property string $delivery_date
 * @property mixed $delivery_description
 * @property string $delivery_status
 * @property string $documents
 * @property string $deleted_at
 * @property string $created_at
 * @property string $updated_at
 * @property Agent $agent
 * @property Business $business
 * @property Customer $customer
 * @property Discount $discount
 * @property Shipment $shipment
 * @property User $users
 * @property VetTex $vetTex
 * @property Warehouse $warehouse
 * @property CustomerTransaction[] $customerTransactions
 * @property InvoiceItem[] $invoiceItems
 * @property ProductReturn[] $productReturns
 * @property SellTransaction[] $sellTransactions
 */
class SellInvoice extends Model
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
    protected $fillable = ['customers_id', 'shipments_id', 'discounts_id', 'vet_texes_id', 'agents_id', 'warehouses_id', 'business_id', 'users_id', 'code', 'name', 'address', 'email', 'contact', 'status', 'payment_term', 'discount_type', 'agent_commission_type', 'labor_cost', 'discount_amount', 'agent_commission', 'vet_texes_amount', 'shipping_charges', 'additional_charges', 'previous_due', 'description', 'due_date', 'is_delivery', 'delivery_address', 'delivery_date', 'delivery_description', 'delivery_status', 'documents', 'deleted_at', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agent()
    {
        return $this->belongsTo('App\Agent', 'agents_id');
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
    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customers_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function discount()
    {
        return $this->belongsTo('App\Discount', 'discounts_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shipment()
    {
        return $this->belongsTo('App\Shipment', 'shipments_id');
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
    public function invoiceItems()
    {
        return $this->hasMany('App\InvoiceItem', 'sell_invoices_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productReturns()
    {
        return $this->hasMany('App\ProductReturn', 'sell_invoices_id');
    }

    public function transactions()
    {
        return $this->hasMany('App\Transaction', 'sell_invoices_id');
    }

    public function setCreatedAtAttribute($value)
    {
        $this->attributes['created_at'] = db_date($value);
    }

    public function setDueDateAttribute($value)
    {
        $this->attributes['due_date'] = db_date($value);
    }

    public function items_discount(){ //Calculate Discount by item
        $ps_discount = $this->invoiceItems()->where('discount_type', 'Percentage')->sum(DB::raw('quantity * (amount * discount_amount / 100)'));
        $fixed_discount = $this->invoiceItems()->where('discount_type', 'Fixed')->sum(DB::raw('discount_amount'));

        return $ps_discount + $fixed_discount;
    }

    public function invoice_total(){
       // $total = $this->invoiceItems()->sum(DB::raw('quantity * (amount - (amount * discount_amount)/100)'));
       // return $total - $this->items_discount();
        $total = 0;
        $table = $this->invoiceItems()->get();
        foreach ($table as $row){
            $total += $row->amount * $row->quantity;
        }
        return $total;
    }

    public function purchase_total(){
        $total = $this->invoiceItems()->sum(DB::raw('quantity * purchase_amount'));
        return $total;
    }

    public function invoice_paid(){
        $total = $this->transactions()->sum('amount');
        return $total;
    }

    public function invoice_sub_total(){
        $total = $this->invoice_total();
        return $total + $this->additional_charges + $this->labor_cost + $this->shipping_charges + $this->vet_texes_amount - $this->discount_amount;
    }

    public function invoice_due(){
        return $this->invoice_sub_total() - $this->invoice_paid();
    }

    public function balance_due(){
        $id = $this->id;
        $customers_id = $this->customers_id;
        $previous_invoices = $this->orderBy('id')->where('id', '<', $id)->where('customers_id', $customers_id)->where('status', 'Final')->get();
        $total_payment = $this->customer->totalAcPayment();
        $current_due = $this->invoice_due();

       if($previous_invoices->count() > 0){
           $previous_due = 0;
           foreach ($previous_invoices as $row){
               $previous_due += $row->invoice_due();
           }

           $remain = $total_payment - $previous_due;

           if($current_due <= 0){
               return 0;
           }else{
               if($remain >= $current_due){
                   return 0;
               }else{
                   if($remain > 0){
                       return $current_due - $remain;
                   }else{
                       return $current_due;
                   }
               }
           }

       }else{

           if($current_due == 0){
               return 0;
           }else{
               if($total_payment >= $current_due){
                   return 0;
               }else{
                   if($total_payment >= 0){
                       $init_due = $current_due - $total_payment;
                       if($init_due > 0){
                           return $init_due;
                       }else{
                           return $current_due;
                       }
                   }else{
                       return $current_due;
                   }
                   
               }
               
           }
       }

    }

    public function main_product(){
        $products = Product::select('id')->where('product_type', 'Main')->pluck('id')->toArray();
        $quantity = $this->invoiceItems()->whereIn('products_id', $products)->sum('quantity');
        $amount = $this->invoiceItems()->whereIn('products_id', $products)->sum('amount');

        return array('qty' => $quantity, 'amount' => $amount);
    }

    public function getBalanceDueAttribute()
    {
        return $this->balance_due();
    }

    public function getSubTotalAttribute()
    {
        return $this->invoice_sub_total();
    }


    public function getInvoiceTotalAttribute()
    {
        return $this->invoice_total();
    }

    public function getPurchaseTotalAttribute()
    {
        return $this->purchase_total();
    }


    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new BusinessScope);
    }

}
