<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact',20)->nullable();
            $table->string('contact_alternate',20)->nullable();
            $table->string('phone',20)->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('proprietor')->nullable();
            $table->string('logo')->nullable();
            $table->string('software_key')->unique();
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
        Schema::dropIfExists('businesses');
    }
}
