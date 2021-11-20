<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('priority')->default(0);
            $table->double('amount')->default(0);
            $table->enum('apply_only',['All', 'General', 'Product', 'Customer', 'Supplier'])->default('General');
            $table->enum('discount_type',['Fixed', 'Percentage'])->default('Fixed');
            $table->boolean('status')->default(1)->comment('0 mean inactive and 1 means active');
            $table->timestamp('start')->nullable();
            $table->timestamp('end')->nullable();
            $table->foreignId('warehouses_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->foreignId('brands_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->foreignId('product_categories_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->foreignId('customer_categories_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->foreignId('business_id')->constrained()->onDelete('cascade')->onUpdate('No Action');
            $table->foreignId('users_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['name', 'status', 'business_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discounts');
    }
}
