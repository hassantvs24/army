<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('transaction_point',['Sells', 'Sells Return', 'Purchase', 'Purchase Return', 'Adjustment', 'Transfer', 'Opening Stock']);
            $table->enum('transaction_type',['IN', 'OUT']);
            $table->string('name')->nullable()->comment('Product Name');
            $table->string('sku')->nullable()->comment('Product SKU');
            $table->string('batch_no')->nullable()->comment('Product Batch No for trace expire date');
            $table->double('amount')->default(0);
            $table->double('quantity')->default(0);
            $table->string('unit',50)->nullable();
            $table->enum('status',['Active','Inactive'])->default('Active');
            $table->foreignId('products_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('No Action');
            $table->foreignId('invoice_items_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('No Action');
            $table->foreignId('purchase_items_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('No Action');
            $table->foreignId('product_return_items_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('No Action');
            $table->foreignId('stock_adjustment_items_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('No Action');
            $table->foreignId('stock_transfer_items_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('No Action');
            $table->foreignId('warehouses_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->foreignId('business_id')->constrained()->onDelete('cascade')->onUpdate('No Action');
            $table->foreignId('users_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_transactions');
    }
}
