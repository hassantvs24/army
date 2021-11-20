<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->double('amount')->default(0);
            $table->string('code')->nullable();
            $table->string('description')->nullable();
            $table->string('document')->nullable()->comment('File attachment');
            $table->unsignedBigInteger('expense_for')->nullable()->comment('Expense for users/employee');
            $table->foreign('expense_for')->references('id')->on('users')->onDelete('SET NULL')->onUpdate('No Action');
            $table->foreignId('expense_categories_id')->constrained()->onDelete('cascade')->onUpdate('No Action');
            $table->foreignId('warehouses_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
            $table->foreignId('business_id')->constrained()->onDelete('cascade')->onUpdate('No Action');
            $table->foreignId('users_id')->nullable()->constrained()->onDelete('SET NULL')->onUpdate('No Action');
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
        Schema::dropIfExists('expenses');
    }
}
