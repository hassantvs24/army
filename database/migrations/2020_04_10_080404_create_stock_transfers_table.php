<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('document')->nullable()->comment('Attach Document');
            $table->double('shipping_charges')->default(0);
            $table->unsignedBigInteger('from_warehouse_id')->comment('warehouses_id');
            $table->foreign('from_warehouse_id')->references('id')->on('warehouses')->onDelete('cascade')->onUpdate('No Action');
            $table->unsignedBigInteger('to_warehouse_id')->comment('warehouses_id');
            $table->foreign('to_warehouse_id')->references('id')->on('warehouses')->onDelete('cascade')->onUpdate('No Action');
            $table->string('description')->nullable();
            $table->foreignId('business_id')->constrained()->onDelete('cascade')->onUpdate('No Action');
            $table->foreignId('users_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['code', 'business_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_transfers');
    }
}
