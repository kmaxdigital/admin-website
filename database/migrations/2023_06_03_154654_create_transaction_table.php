<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->integer('user_id');
            $table->string('email')->nullable();
            $table->integer('plan_id')->nullable();
            $table->string('gateway');
            $table->string('payment_amount');
            $table->string('payment_id');
            $table->integer('date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction');
    }
}
