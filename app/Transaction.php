<?php

namespace App;

use App\Scopes\BusinessScope;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $expenses_id
 * @property integer $sell_invoices_id
 * @property integer $customers_id
 * @property integer $purchase_invoices_id
 * @property integer $suppliers_id
 * @property integer $agents_id
 * @property integer $stock_adjustments_id
 * @property integer $account_books_id
 * @property integer $warehouses_id
 * @property integer $business_id
 * @property integer $users_id
 * @property string $transaction_point
 * @property string $transaction_hub
 * @property string $transaction_type
 * @property integer $ref_id
 * @property float $amount
 * @property string $payment_method
 * @property string $card_number
 * @property string $card_holder_name
 * @property string $card_transaction_no
 * @property string $card_type
 * @property string $card_month
 * @property integer $card_year
 * @property integer $csv
 * @property string $cheque_number
 * @property string $bank_account_no
 * @property string $transaction_no
 * @property string $description
 * @property string $status
 * @property string $deleted_at
 * @property string $created_at
 * @property string $updated_at
 * @property AccountBook $accountBook
 * @property Agent $agent
 * @property Business $business
 * @property Customer $customer
 * @property Expense $expense
 * @property PurchaseInvoice $purchaseInvoice
 * @property SellInvoice $sellInvoice
 * @property StockAdjustment $stockAdjustment
 * @property Supplier $supplier
 * @property User $user
 * @property Warehouse $warehouse
 */
class Transaction extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['expenses_id', 'sell_invoices_id', 'customers_id', 'purchase_invoices_id', 'suppliers_id', 'agents_id', 'stock_adjustments_id', 'account_books_id', 'warehouses_id', 'business_id', 'users_id', 'transaction_point', 'transaction_hub', 'transaction_type', 'ref_id', 'amount', 'payment_method', 'card_number', 'card_holder_name', 'card_transaction_no', 'card_type', 'card_month', 'card_year', 'csv', 'cheque_number', 'bank_account_no', 'transaction_no', 'description', 'status', 'deleted_at', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function accountBook()
    {
        return $this->belongsTo('App\AccountBook', 'account_books_id');
    }

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
    public function expense()
    {
        return $this->belongsTo('App\Expense', 'expenses_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function purchaseInvoice()
    {
        return $this->belongsTo('App\PurchaseInvoice', 'purchase_invoices_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sellInvoice()
    {
        return $this->belongsTo('App\SellInvoice', 'sell_invoices_id');
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
    public function supplier()
    {
        return $this->belongsTo('App\Supplier', 'suppliers_id');
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

    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = abs($value);
    }

    public function setCreatedAtAttribute($value)
    {
        $this->attributes['created_at'] = db_date($value);
    }

    public function in(){
        $amount = ($this->transaction_type == 'IN' ? $this->amount:0);
        return $amount;
    }

    public function out(){
        $amount = ($this->transaction_type == 'OUT' ? $this->amount:0);
        return $amount;
    }

    public function payment_number(){

        switch ($this->payment_method) {
            case "Cheque":
                $title = 'Cheque Number';
                $numbers = $this->cheque_number;
                break;
            case "Bank Transfer":
                $title = 'Account Number';
                $numbers = $this->bank_account_no;
                break;
            case "Other":
                $title = 'Other Transaction Number';
                $numbers = $this->transaction_no;
                break;
            default:
                $title = 'Payment Number';
                $numbers = '';
        }

        return array('title' => $title, 'numbers' => $numbers);
    }


    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new BusinessScope);
    }
}
