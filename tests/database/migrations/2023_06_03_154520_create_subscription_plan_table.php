<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_plan', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('plan_name');
            $table->integer('plan_days');
            $table->string('plan_duration');
            $table->string('plan_duration_type');
            $table->decimal('plan_price', 11, 2);
            $table->integer('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription_plan');
    }
}
