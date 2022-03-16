<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DpProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dp_project', function (Blueprint $table) {
            $table->bigIncrements("project_id");
            $table->string('project_name');
            $table->text('project_desc')->nullable();
            $table->unsignedBigInteger('project_users');
            $table->dateTime('project_created', 0)->useCurrent();
            $table->dateTime('project_updated', 0)->useCurrent()->useCurrentOnUpdate();

            $table->foreign('project_users')->references('users_id')->on('dp_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dp_project');
    }
}
