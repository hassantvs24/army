<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact_person')->nullable();
            $table->string('code')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('contact',15)->nullable();
            $table->string('phone',15)->nullable();
            $table->string('alternate_contact',15)->nullable();
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->enum('pay_term',['Daily', 'Monthly', 'Yearly'])->default('Daily');
            $table->double('credit_limit')->default(0)->comment('0 for no limit');
            $table->double('balance')->default(0);
            $table->double('sells_target')->default(0)->comment('Monthly Sells Target');
            $table->foreignId('agent_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->foreignId('zones_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->foreignId('unions_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->foreignId('upa_zillas_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->foreignId('zillas_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->foreignId('divisions_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->foreignId('vet_texes_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->foreignId('customer_categories_id')->constrained()->onDelete('cascade')->onUpdate('No Action');
            $table->foreignId('warehouses_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->foreignId('business_id')->constrained()->onDelete('cascade')->onUpdate('No Action');
            $table->foreignId('users_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['name', 'contact', 'email', 'business_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
