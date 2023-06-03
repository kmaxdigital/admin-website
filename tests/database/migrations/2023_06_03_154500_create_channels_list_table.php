<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelsListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channels_list', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('channel_cat_id');
            $table->string('channel_access')->default('Paid');
            $table->string('channel_name');
            $table->string('channel_slug');
            $table->text('channel_description')->nullable();
            $table->string('channel_thumb');
            $table->string('channel_url_type');
            $table->string('channel_url', 500);
            $table->string('channel_url2', 500)->nullable();
            $table->string('channel_url3', 500)->nullable();
            $table->string('seo_title')->nullable();
            $table->string('seo_description', 500)->nullable();
            $table->string('seo_keyword', 500)->nullable();
            $table->bigInteger('views')->default(0);
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
        Schema::dropIfExists('channels_list');
    }
}
