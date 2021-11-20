<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpaZillasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upa_zillas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('zillas_id')->constrained()->onDelete('cascade')->onUpdate('No Action');
            $table->foreignId('business_id')->constrained()->onDelete('cascade')->onUpdate('No Action');
            $table->foreignId('users_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['name', 'zillas_id', 'business_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('upa_zillas');
    }
}
