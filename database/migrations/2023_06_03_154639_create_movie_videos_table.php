<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovieVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movie_videos', function (Blueprint $table) {
            $table->id()->index();
            $table->string('video_access')->default('Paid');
            $table->integer('movie_lang_id');
            $table->text('movie_genre_id');
            $table->integer('upcoming')->default(0);
            $table->text('video_title');
            $table->integer('release_date')->nullable();
            $table->string('duration')->nullable();
            $table->text('video_description')->nullable();
            $table->text('actor_id')->nullable();
            $table->text('director_id')->nullable();
            $table->string('video_slug', 200)->nullable();
            $table->string('video_image_thumb')->nullable();
            $table->string('video_image', 200)->nullable();
            $table->text('trailer_url')->nullable();
            $table->string('video_type')->nullable();
            $table->integer('video_quality')->nullable();
            $table->longText('video_url')->nullable();
            $table->string('video_url_480')->nullable();
            $table->string('video_url_720')->nullable();
            $table->string('video_url_1080')->nullable();
            $table->integer('download_enable')->nullable();
            $table->string('download_url', 500)->nullable();
            $table->integer('subtitle_on_off')->nullable();
            $table->string('subtitle_language1')->nullable();
            $table->string('subtitle_url1', 500)->nullable();
            $table->string('subtitle_language2')->nullable();
            $table->string('subtitle_url2')->nullable();
            $table->string('subtitle_language3')->nullable();
            $table->string('subtitle_url3')->nullable();
            $table->string('imdb_id')->nullable();
            $table->string('imdb_rating')->nullable();
            $table->string('imdb_votes')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('seo_description', 500)->nullable();
            $table->string('seo_keyword', 500)->nullable();
            $table->bigInteger('views')->default(0);
            $table->string('content_rating')->nullable();
            $table->integer('status')->default(1);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movie_videos');
    }
}
