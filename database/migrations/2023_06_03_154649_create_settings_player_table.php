<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsPlayerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_player', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('player_style')->nullable();
            $table->string('player_watermark')->nullable();
            $table->string('player_logo')->nullable();
            $table->string('player_logo_position')->nullable();
            $table->string('player_url')->nullable();
            $table->string('autoplay')->default('false');
            $table->string('pip_mode')->default('ON');
            $table->string('rewind_forward')->default('ON');
            $table->string('player_ad_on_off')->default('OFF');
            $table->string('ad_offset')->nullable();
            $table->string('ad_skip')->nullable();
            $table->string('ad_web_url')->nullable();
            $table->string('ad_video_type')->default('Local');
            $table->string('ad_video_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings_player');
    }
}
