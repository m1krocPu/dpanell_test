<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DpProjectTodo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {Schema::create('dp_project_todo', function (Blueprint $table) {
            $table->bigIncrements("todo_id");
            $table->unsignedBigInteger('todo_project');
            $table->string('todo_name');
            $table->text('todo_desc')->nullable();
            $table->integer('todo_parent')->default(0);
            $table->dateTime('todo_created', 0)->useCurrent();
            $table->dateTime('todo_updated', 0)->useCurrent()->useCurrentOnUpdate();

            $table->foreign('todo_project')->references('project_id')->on('dp_project')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dp_project_todo');
    }
}
