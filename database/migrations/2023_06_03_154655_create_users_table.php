<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('users');

        Schema::create('users', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('usertype')->default('User');
            $table->integer('login_status')->default(0);
            $table->string('google_id')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('user_address', 500)->nullable();
            $table->string('user_image')->nullable();
            $table->integer('status')->default(1);
            $table->integer('plan_id')->default(0);
            $table->integer('start_date')->nullable();
            $table->integer('exp_date')->nullable();
            $table->string('plan_amount')->default('0');
            $table->string('confirmation_code')->nullable();
            $table->rememberToken();
            $table->text('session_id')->nullable();
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
        Schema::dropIfExists('users');
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }
}
