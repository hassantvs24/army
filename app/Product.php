<?php

namespace App;

use App\Scopes\BusinessScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * @property integer $id
 * @property integer $product_categories_id
 * @property integer $sub_product_categories_id
 * @property integer $brands_id
 * @property integer $companies_id
 * @property integer $units_id
 * @property integer $vet_texes_id
 * @property integer $business_id
 * @property integer $users_id
 * @property string $name
 * @property string $sku
 * @property float $sell_price
 * @property float $purchase_price
 * @property string $product_type
 * @property boolean $enable_stock
 * @property boolean $enable_expire
 * @property boolean $enable_serial
 * @property int $alert_quantity
 * @property int $alert_expire_day
 * @property string $barcode
 * @property mixed $custom_field
 * @property string $image
 * @property mixed $description
 * @property float $stock
 * @property boolean $is_active
 * @property string $tax_type
 * @property string $deleted_at
 * @property string $created_at
 * @property string $updated_at
 * @property Brand $brand
 * @property Business $business
 * @property Company $company
 * @property ProductCategory $productCategory
 * @property Unit $unit
 * @property User $users
 * @property VetTex $vetTex
 * @property InvoiceItem[] $invoiceItems
 * @property ProductReturnItem[] $productReturnItems
 * @property PurchaseItem[] $purchaseItems
 * @property StockAdjustmentItem[] $stockAdjustmentItems
 * @property StockTransaction[] $stockTransactions
 * @property StockTransferItem[] $stockTransferItems
 */
class Product extends Model
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
    protected $fillable = ['product_categories_id', 'sub_product_categories_id', 'brands_id', 'companies_id', 'units_id', 'vet_texes_id', 'business_id', 'users_id', 'name', 'sku', 'sell_price', 'purchase_price', 'product_type', 'enable_stock', 'enable_expire', 'enable_serial', 'alert_quantity', 'alert_expire_day', 'barcode', 'custom_field', 'image', 'description', 'stock', 'is_active', 'tax_type', 'deleted_at', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo('App\Brand', 'brands_id');
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
    public function company()
    {
        return $this->belongsTo('App\Company', 'companies_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productCategory()
    {
        return $this->belongsTo('App\ProductCategory', 'product_categories_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productSubCategory()
    {
        return $this->belongsTo('App\ProductCategory', 'sub_product_categories_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unit()
    {
        return $this->belongsTo('App\Units', 'units_id');
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoiceItems()
    {
        return $this->hasMany('App\InvoiceItem', 'products_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productReturnItems()
    {
        return $this->hasMany('App\ProductReturnItem', 'products_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchaseItems()
    {
        return $this->hasMany('App\PurchaseItem', 'products_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stockAdjustmentItems()
    {
        return $this->hasMany('App\StockAdjustmentItem', 'products_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stockTransactions()
    {
        return $this->hasMany('App\StockTransaction', 'products_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stockTransferItems()
    {
        return $this->hasMany('App\StockTransferItem', 'products_id');
    }

    public function currentStock(){
        $openingStock = $this->stock;

        $out_product = $this->invoiceItems()->where('status', 'Active')->sum('quantity');
        $in_product = $this->purchaseItems()->where('status', 'Active')->sum('quantity');

        $out_adjust = $this->stockAdjustmentItems()->where('adjustment_action', 'OUT')->sum('quantity');
        $in_adjust = $this->stockAdjustmentItems()->where('adjustment_action', 'IN')->sum('quantity');

        $out_return = $this->productReturnItems()->where('return_type', 'Purchase Return')->sum('quantity');
        $in_return = $this->productReturnItems()->where('return_type', 'Sells Return')->sum('quantity');

        $total = ($openingStock + $in_product + $in_return + $in_adjust) - ($out_product + $out_adjust + $out_return);


        return $total;
    }

    public function getCurrentStockAttribute()
    {
        return $this->currentStock();
    }

    public function stock_low(){
        if($this->alert_quantity == 0 || $this->currentStock() >= $this->alert_quantity){
            return 0;
        }else{
            return 1;
        }
    }

    public function getStockLowerAttribute()
    {
        return $this->stock_low();
    }

    public function current_stock_value(){
        $total = $this->currentStock() * $this->purchase_price;
        return $total;
    }

    public function getStockValueAttribute()
    {
        return $this->current_stock_value();
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new BusinessScope);
    }
}
