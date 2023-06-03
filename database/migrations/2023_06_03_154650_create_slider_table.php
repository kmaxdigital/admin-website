<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSliderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slider', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('slider_title', 500);
            $table->string('slider_image');
            $table->string('slider_type')->nullable();
            $table->integer('slider_post_id')->nullable();
            $table->string('slider_display_on')->default('Home');
            $table->text('slider_url')->nullable();
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
        Schema::dropIfExists('slider');
    }
}
