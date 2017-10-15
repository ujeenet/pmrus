<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name');
            $table->integer('resource_id')->nullable();
            $table->string('title');
            $table->integer('exp_duration')->nullable();
            $table->integer('duration')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['on_hold','in_process','done','discard']);
            $table->enum('type', ['upgrade','fix','experimental','new','schedule']);
            $table->text('starts_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
