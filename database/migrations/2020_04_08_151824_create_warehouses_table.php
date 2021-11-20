<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouses', function (Blueprint $table) {//Business Branch
            $table->id();
            $table->string('name');
            $table->string('contact',20)->nullable()->comment('OR Default from business table');
            $table->string('contact_alternate',20)->nullable()->comment('OR Default from business table');
            $table->string('phone',20)->nullable()->comment('OR Default from business table');
            $table->string('address')->nullable()->comment('OR Default from business table');
            $table->string('email')->nullable()->comment('OR Default from business table');
            $table->string('website')->nullable()->comment('OR Default from business table');
            $table->string('proprietor')->nullable()->comment('OR Default from business table');
            $table->string('logo')->nullable()->comment('OR Default from business table');
            $table->boolean('status')->default(1)->comment('0 mean inactive and 1 means active');
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
        Schema::dropIfExists('warehouses');
    }
}
