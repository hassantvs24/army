<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku');
            $table->double('sell_price')->default(0)->comment('Default sells price for init price');
            $table->double('purchase_price')->default(0)->comment('Default Purchase price for init price');
            $table->enum('product_type',['Main', 'Other'])->default('Main')->comment('Main product of business like add to customer target');
            $table->boolean('enable_stock')->default(1)->comment('0 mean not enable to count in stock');
            $table->boolean('enable_expire')->default(0)->comment('0 mean not enable');
            $table->boolean('enable_serial')->default(0)->comment('0 mean not enable serial/IMIEI no');
            $table->integer('alert_quantity')->default(0);
            $table->integer('alert_expire_day')->default(0);
            $table->enum('barcode',['C39','C128','EAN13','EAN8','UPCA','UPCE'])->nullable();
            $table->string('custom_field')->nullable()->comment('custom field like size, weight etc.');
            $table->string('image')->nullable();
            $table->string('description')->nullable();
            $table->double('stock')->default(0);
            $table->boolean('is_active')->default(1)->comment('0 mean inactive');
            $table->foreignId('product_categories_id')->constrained()->onDelete('cascade')->onUpdate('No Action');
            $table->unsignedBigInteger('sub_product_categories_id')->nullable();
            $table->foreign('sub_product_categories_id')->references('id')->on('product_categories')->onDelete('SET NULL')->onUpdate('No Action');
            $table->foreignId('brands_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->foreignId('companies_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->foreignId('units_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->foreignId('vet_texes_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->enum('tax_type', ['Inclusive', 'Exclusive'])->nullable();
            $table->foreignId('business_id')->constrained()->onDelete('cascade')->onUpdate('No Action');
            $table->foreignId('users_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['sku', 'business_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
