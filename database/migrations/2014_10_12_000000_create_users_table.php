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
        Schema::create('dp_users', function (Blueprint $table) {
            $table->bigIncrements("users_id");
            $table->string('users_name');
            $table->string('users_email')->unique();
            $table->string('users_pwd');
            $table->enum('users_level',['admin','employee'])->default('employee');
            $table->dateTime('users_logged', 0)->nullable();
            $table->dateTime('users_created', 0)->useCurrent();
            $table->dateTime('users_updated', 0)->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dp_users');
    }
}
