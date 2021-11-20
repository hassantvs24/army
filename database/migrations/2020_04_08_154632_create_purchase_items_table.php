<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->comment('Product Name');
            $table->string('sku')->nullable()->comment('Product SKU');
            $table->string('batch_no')->nullable()->comment('Product Batch No for trace expire date');
            $table->date('expire_date')->nullable()->comment('expire date');
            $table->double('quantity')->default(0);
            $table->double('amount')->default(0);
            $table->string('unit',50)->nullable();
            $table->enum('discount_type',['Fixed', 'Percentage'])->default('Fixed');
            $table->double('discount_amount')->default(0);
            $table->double('vat_amount')->default(0);
            $table->enum('status',['Active','Inactive'])->default('Active');
            $table->foreignId('warehouses_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->foreignId('products_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->foreignId('purchase_invoices_id')->constrained()->onDelete('cascade')->onUpdate('No Action');
            $table->foreignId('business_id')->constrained()->onDelete('cascade')->onUpdate('No Action');
            $table->foreignId('users_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['purchase_invoices_id', 'products_id', 'batch_no', 'business_id'], 'uniq_purchase_item');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_items');
    }
}
