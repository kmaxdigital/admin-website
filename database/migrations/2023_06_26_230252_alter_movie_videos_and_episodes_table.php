<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movie_videos', function($table) 
        {
            $table->uuid('unique_id')->after('id');
            $table->enum('is_processed', ['0', '1'])->after('content_rating')->default('0');
            $table->enum('is_verify', ['pending','inprocess','verified'])->after('is_processed')->default('pending');
            $table->enum('is_upload', ['yes','no'])->after('is_verify')->default('no');

        });



        Schema::table('episodes', function($table) 
        {
            $table->uuid('unique_id')->after('id');
            $table->enum('is_processed', ['0', '1'])->after('views')->default('0');
            $table->enum('is_verify', ['pending','inprocess','verified'])->after('is_processed')->default('pending');
            $table->enum('is_upload', ['yes','no'])->after('is_verify')->default('no');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movie_videos', function($table) {
            $table->dropColumn('unique_id');
            $table->dropColumn('is_processed');
            $table->dropColumn('is_verify');
            $table->dropColumn('is_upload');
        }); 

               

        Schema::table('episodes', function($table) {
            $table->dropColumn('unique_id');
            $table->dropColumn('is_processed');
            $table->dropColumn('is_verify');
            $table->dropColumn('is_upload');
        });
    }
};
