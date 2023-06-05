<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsAndroidAppTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_android_app', function (Blueprint $table) {
            $table->id();
            $table->string('app_name');
            $table->string('app_logo')->nullable();
            $table->string('app_version')->nullable();
            $table->string('app_company')->nullable();
            $table->string('app_email')->nullable();
            $table->string('app_website')->nullable();
            $table->string('app_contact')->nullable();
            $table->text('app_about')->nullable();
            $table->text('app_privacy')->nullable();
            $table->text('app_terms')->nullable();
            $table->string('onesignal_app_id')->nullable();
            $table->string('onesignal_rest_key')->nullable();
            $table->string('app_update_hide_show')->nullable();
            $table->string('app_update_version_code')->nullable();
            $table->text('app_update_desc')->nullable();
            $table->string('app_update_link')->nullable();
            $table->string('app_update_cancel_option')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings_android_app');
    }
}
