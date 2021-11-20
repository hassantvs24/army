<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductReturnItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_return_items', function (Blueprint $table) {
            $table->id();
            $table->enum('return_type',['Sells Return', 'Purchase Return'])->default('Sells Return');
            $table->string('name')->nullable()->comment('Product Name');
            $table->string('sku')->nullable()->comment('Product SKU');
            $table->string('batch_no')->nullable()->comment('Product Batch No for trace expire date');
            $table->date('expire_date')->nullable()->comment('expire date');
            $table->double('quantity')->default(0);
            $table->double('amount')->default(0);
            $table->string('unit',50)->nullable();
            $table->foreignId('products_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->foreignId('warehouses_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->foreignId('product_returns_id')->constrained()->onDelete('cascade')->onUpdate('No Action');
            $table->foreignId('business_id')->constrained()->onDelete('cascade')->onUpdate('No Action');
            $table->foreignId('users_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['products_id', 'product_returns_id', 'batch_no', 'business_id'], 'unique_return_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_return_items');
    }
}
