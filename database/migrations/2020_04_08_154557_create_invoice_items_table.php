<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->comment('Product Name');
            $table->string('sku')->nullable()->comment('Product SKU');
            $table->string('batch_no')->nullable()->comment('Product Batch No for trace expire date');
            $table->double('purchase_amount')->default(0);
            $table->double('quantity')->default(0);
            $table->double('amount')->default(0);
            $table->string('unit',50)->nullable();
            $table->enum('discount_type',['Fixed', 'Percentage'])->default('Fixed');
            $table->double('discount_amount')->default(0);
            $table->double('vat_amount')->default(0);
            $table->enum('status',['Active','Inactive'])->default('Active');
            $table->foreignId('warehouses_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->foreignId('products_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->foreignId('sell_invoices_id')->constrained()->onDelete('cascade')->onUpdate('No Action');
            $table->foreignId('business_id')->constrained()->onDelete('cascade')->onUpdate('No Action');
            $table->foreignId('users_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['sell_invoices_id', 'products_id', 'batch_no', 'business_id'], 'uniq_invoice_item');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_items');
    }
}
