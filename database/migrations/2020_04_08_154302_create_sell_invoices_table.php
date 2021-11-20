<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sell_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('name')->nullable()->comment('Customer Name');
            $table->string('address')->nullable()->comment('Customer Address');
            $table->string('email')->nullable()->comment('Customer Email');
            $table->string('contact',15)->nullable()->comment('Customer Contact');
            $table->enum('status',['Final', 'Draft', 'Quotation'])->default('Final');
            $table->enum('payment_term',['Daily', 'Monthly', 'Yearly'])->default('Daily');
            $table->enum('discount_type',['Fixed', 'Percentage'])->default('Fixed');
            $table->enum('agent_commission_type',['Fixed', 'Percentage'])->default('Fixed');
            $table->double('labor_cost')->default(0);
            $table->double('discount_amount')->default(0);
            $table->double('agent_commission')->default(0);
            $table->double('vet_texes_amount')->default(0);
            $table->double('shipping_charges')->default(0);
            $table->double('additional_charges')->default(0);
            $table->double('previous_due')->default(0);
            $table->string('description')->nullable();
            $table->date('due_date')->nullable();
            $table->boolean('is_delivery')->default(0);
            $table->string('delivery_address')->nullable();
            $table->string('delivery_date')->nullable();
            $table->string('delivery_description')->nullable();
            $table->enum('delivery_status', ['Pending Delivery', 'On The Way', 'Delivered'])->nullable();
            $table->string('documents')->nullable()->comment('Attach Document Upload');
            $table->foreignId('customers_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('No Action');
            $table->foreignId('shipments_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->foreignId('discounts_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->foreignId('vet_texes_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->foreignId('agents_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
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
        Schema::dropIfExists('sell_invoices');
    }
}
