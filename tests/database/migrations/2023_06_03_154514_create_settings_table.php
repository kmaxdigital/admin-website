<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('time_zone')->default('UTC');
            $table->string('default_language')->default('en');
            $table->string('styling')->default('light');
            $table->string('site_name');
            $table->string('site_email');
            $table->string('site_logo');
            $table->string('site_favicon');
            $table->text('site_description')->nullable();
            $table->text('site_keywords')->nullable();
            $table->text('site_header_code')->nullable();
            $table->text('site_footer_code')->nullable();
            $table->text('site_copyright');
            $table->string('currency_code');
            $table->string('footer_fb_link', 500)->nullable();
            $table->string('footer_twitter_link', 500)->nullable();
            $table->string('footer_instagram_link', 500)->nullable();
            $table->string('footer_google_play_link', 500)->nullable();
            $table->string('footer_apple_store_link', 500)->nullable();
            $table->string('smtp_host')->nullable();
            $table->string('smtp_port')->nullable();
            $table->string('smtp_email')->nullable();
            $table->string('smtp_password')->nullable();
            $table->string('smtp_encryption')->nullable();
            $table->string('gdpr_cookie_title', 500)->nullable();
            $table->text('gdpr_cookie_text')->nullable();
            $table->string('gdpr_cookie_url')->nullable();
            $table->string('omdb_api_key')->nullable();
            $table->string('external_css_js')->default('local');
            $table->string('google_login')->default('false');
            $table->string('facebook_login')->default('false');
            $table->string('google_client_id')->nullable();
            $table->string('google_client_secret')->nullable();
            $table->text('google_redirect')->nullable();
            $table->string('facebook_app_id')->nullable();
            $table->string('facebook_client_secret')->nullable();
            $table->text('facebook_redirect')->nullable();
            $table->mode`('maintenance');
            $table->string('envato_buyer_name')->nullable();
            $table->string('envato_purchase_code')->nullable();
            $table->integer('menu_shows')->default(1);
            $table->integer('menu_movies')->default(1);
            $table->integer('menu_sports')->default(1);
            $table->integer('menu_livetv')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
