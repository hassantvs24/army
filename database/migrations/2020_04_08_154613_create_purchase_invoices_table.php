<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('name')->nullable()->comment('Supplier Name');
            $table->string('address')->nullable()->comment('Supplier Address');
            $table->string('email')->nullable()->comment('Supplier Email');
            $table->string('contact',15)->nullable()->comment('Supplier Contact');
            $table->enum('status',['Received', 'Pending', 'Ordered'])->default('Received');
            $table->double('labor_cost')->default(0);
            $table->double('discount_amount')->default(0);
            $table->double('vet_texes_amount')->default(0);
            $table->double('shipping_charges')->default(0);
            $table->double('additional_charges')->default(0);
            $table->double('due_date')->nullable();
            $table->string('description')->nullable();
            $table->string('documents')->nullable()->comment('Attach Document Upload');
            $table->foreignId('suppliers_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('No Action');
            $table->foreignId('shipments_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->foreignId('discounts_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->foreignId('vet_texes_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->foreignId('warehouses_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
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
        Schema::dropIfExists('purchase_invoices');
    }
}
