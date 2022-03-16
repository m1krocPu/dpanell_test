<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DpProjectTodoSub extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('dp_project_todo_sub', function (Blueprint $table) {
            $table->bigIncrements("sub_id");
            $table->unsignedBigInteger('sub_todo');
            $table->string('sub_name');
            $table->integer('sub_status')->default(0);
            $table->dateTime('sub_created', 0)->useCurrent();
            $table->dateTime('sub_updated', 0)->useCurrent()->useCurrentOnUpdate();

            $table->foreign('sub_todo')->references('todo_id')->on('dp_project_todo')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dp_project_todo_sub');
    }
}
