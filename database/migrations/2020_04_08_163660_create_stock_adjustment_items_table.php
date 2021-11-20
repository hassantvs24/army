<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockAdjustmentItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_adjustment_items', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->comment('Product Name');
            $table->string('sku')->nullable()->comment('Product SKU');
            $table->string('batch_no')->nullable()->comment('Product Batch No for trace expire date');
            $table->date('expire_date')->nullable()->comment('expire date');
            $table->double('quantity')->default(0);
            $table->double('amount')->default(0);
            $table->string('unit',50)->nullable();
            $table->enum('adjustment_action',['OUT', 'IN'])->default('OUT');
            $table->foreignId('products_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->foreignId('warehouses_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->foreignId('stock_adjustments_id')->constrained()->onDelete('cascade')->onUpdate('No Action');
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
        Schema::dropIfExists('stock_adjustment_items');
    }
}
