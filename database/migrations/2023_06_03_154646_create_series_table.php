<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->integer('series_lang_id');
            $table->text('series_genres');
            $table->integer('upcoming')->default(0);
            $table->string('series_access')->default('Paid');
            $table->string('series_name', 500);
            $table->string('series_slug');
            $table->text('series_info');
            $table->text('actor_id')->nullable();
            $table->text('director_id')->nullable();
            $table->string('series_poster', 500);
            $table->string('imdb_id')->nullable();
            $table->string('imdb_rating')->nullable();
            $table->string('imdb_votes')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('seo_description', 500)->nullable();
            $table->string('seo_keyword', 500)->nullable();
            $table->string('content_rating')->nullable();
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
        Schema::dropIfExists('series');
    }
}
